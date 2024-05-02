<?php

namespace Kitchen\News\Block;

use Kitchen\News\Model\GalleryFactory;
use Magento\Framework\UrlInterface;

class Index extends \Magento\Framework\View\Element\Template
{
    protected $galleryFactory;
    protected $urlBuilder;
    protected $timezoneInterface;
    /**
     * @var \Magento\Framework\Serialize\Serializer\Json
     */
    protected $_json;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        GalleryFactory $galleryFactory,
        UrlInterface $urlBuilder,
        \Magento\Framework\Stdlib\DateTime\TimezoneInterface $timezoneInterface,
        \Magento\Framework\Serialize\Serializer\Json $json
    ) {
        $this->galleryFactory = $galleryFactory;
        $this->timezoneInterface = $timezoneInterface;
        $this->urlBuilder = $urlBuilder;
        $this->_json = $json;
        parent::__construct($context);
    }

    public function datalog()
    {
        $data = [
            "name" => "ABC",
            "Age" => 19
        ];

        echo "Encode: ";
        $str = $this->_json->serialize($data);
        print_r($str);
        echo "Decode: ";
        $str_d = $this->_json->unserialize($str);
        print_r($str_d);
    }

    public function show()
    {

        $model = $this->galleryFactory->create();
        echo "<pre>";
        print_r($model->getCollection()->getData());
        echo "</pre>";
    }

    public function showData()
    {
        $varOne = $this->getRequest()->getPostValue('newsFilter');
        $varSort = $this->getRequest()->getPost('newsSort');
        $varCreate = $this->galleryFactory->create();
        $varCollection = $varCreate->getCollection();

        if ($varCollection !== '') {
            $varCollection->addFieldToFilter('is_active', $varOne);
        }
        if ($varSort !== NULL) {
            $varCollection->setOrder('news_id', $varSort);
        }
        foreach ($varCollection as $row) {
            echo "<tr>";
            echo "<td>" . $row->getNewsId() . "</td>";
            echo "<td>" . $row->getNewsTitle() . "</td>";
            echo "<td>" . $row->getNewsDesc() . "</td>";
            echo "<td>" . $row->getIsActive() . "</td>";
            echo "<td>" . $row->getCreationTime() . "</td>";
            echo "<td>" . $row->getUpdateTime() . "</td>";
            echo "<td><a href='" . $this->urlBuilder->getUrl('news/index/index', ['id' => $row->getNewsId()]) . "'>Edit</a></td>";
            echo "<td><a href='" . $this->urlBuilder->getUrl('news/index/delete', ['id' => $row->getNewsId()]) . "'>Delete</a></td>";
            echo "</tr>";
        }
        //  $id = $this->getRequest()->getparam("id");

    }

    public function msg()
    {
        return __("Disha is smart...");
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('News').$this->timezoneInterface->date()->format('Y-m-d H:i:s')); // set page name
        $breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs');
        $baseUrl = $this->_storeManager->getStore()->getBaseUrl();
        // $baseUrlOne = $this->_storeManager->getStore()->getBaseUrl('http://us365.localhost.com/mobile/samsung.html');

        if ($breadcrumbsBlock) {

            $breadcrumbsBlock->addCrumb(
                'home',
                [
                    'label' => __('Home'), //lable on breadCrumbes
                    'title' => __('Home'),
                    'link' => $baseUrl
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'news',
                [
                    'label' => __('News'),
                    'title' => __('News'),
                    'link' => 'http://us365.localhost.com/mobile/samsung.html' //set link path
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'education',
                [
                    'label' => __('Education News'),
                    'title' => __('Education News'),
                    'link' => '' //set link path
                ]
            );
            $breadcrumbsBlock->addCrumb(
                'school',
                [
                    'label' => __('School News'),
                    'title' => __('School News'),
                    'link' => '' //set link path
                ]
            );
        }
        return parent::_prepareLayout();
    }
}
