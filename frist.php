<?php
namespace DCOnline\Sales\Block\Order\History;

use Magento\Framework\App\Filesystem\DirectoryList;

class Download extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    /**
     * Filesystem
     * @var \Magento\Framework\Filesystem     123
     */ 
    protected $filesystem;

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Framework\App\Filesystem\DirectoryList $directory_list
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Filesystem $filesystem,
        array $data = []
    ) {
        $this->filesystem = $filesystem;
        $this->customerSession = $customerSession;
        parent::__construct($context, $data);
    }

    /**
     * 判断当前用户是否有旧订单,
     *
     * @return void
     */
    public function getDownloadButton()
    {
        if ($this->customerSession->authenticate()) {
            // 用户
            $customer = $this->customerSession->getCustomer();
            if ($customer) {
                $readDirectory = $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
                $fileName = $readDirectory->getAbsolutePath(static::FILE_PATH) . $customer->getEmail() . 'zip';
                if (file_exists($fileName)) {
                    $buttons = array('url' => $this->getUrl('sales/history/download'), 'text' => 'Download your previous orders');
                }
            }
        }
        return isset($buttons) ? $buttons : null;
    }
}
