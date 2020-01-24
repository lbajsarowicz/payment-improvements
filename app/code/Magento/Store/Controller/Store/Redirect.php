<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Store\Controller\Store;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Api\StoreRepositoryInterface;
use Magento\Store\Api\StoreResolverInterface;
use Magento\Store\Model\StoreResolver;
use Magento\Framework\Session\SidResolverInterface;

/**
 * Builds correct url to target store (group) and performs redirect.
 */
class Redirect extends \Magento\Framework\App\Action\Action
{
    /**
     * @var StoreRepositoryInterface
     */
    private $storeRepository;

    /**
     * @var StoreResolverInterface
     */
    private $storeResolver;

    /**
     * @param Context $context
     * @param StoreRepositoryInterface $storeRepository
     * @param StoreResolverInterface $storeResolver
     * @param \Magento\Framework\Session\Generic $session
     * @param SidResolverInterface $sidResolver
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function __construct(
        Context $context,
        StoreRepositoryInterface $storeRepository,
        StoreResolverInterface $storeResolver,
        \Magento\Framework\Session\Generic $session,
        SidResolverInterface $sidResolver
    ) {
        parent::__construct($context);
        $this->storeRepository = $storeRepository;
        $this->storeResolver = $storeResolver;
    }

    /**
     * @inheritDoc
     *
     * @throws NoSuchEntityException
     */
    public function execute()
    {
        /** @var \Magento\Store\Model\Store $currentStore */
        $currentStore = $this->storeRepository->getById($this->storeResolver->getCurrentStoreId());
        $targetStoreCode = $this->_request->getParam(StoreResolver::PARAM_NAME);
        $fromStoreCode = $this->_request->getParam('___from_store');
        $error = null;

        if ($targetStoreCode === null) {
            return $this->_redirect($currentStore->getBaseUrl());
        }

        try {
            /** @var \Magento\Store\Model\Store $targetStore */
            $fromStore = $this->storeRepository->get($fromStoreCode);
        } catch (NoSuchEntityException $e) {
            $error = __('Requested store is not found');
        }

        if ($error !== null) {
            $this->messageManager->addErrorMessage($error);
            $this->_redirect->redirect($this->_response, $currentStore->getBaseUrl());
        } else {
            $encodedUrl = $this->_request->getParam(\Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED);

            $query = [
                '___from_store' => $fromStore->getCode(),
                StoreResolverInterface::PARAM_NAME => $targetStoreCode,
                \Magento\Framework\App\ActionInterface::PARAM_NAME_URL_ENCODED => $encodedUrl,
            ];

            $arguments = [
                '_nosid' => true,
                '_query' => $query
            ];
            $this->_redirect->redirect($this->_response, 'stores/store/switch', $arguments);
        }
    }
}
