<?php
namespace Kitchen\News\Block\Adminhtml\Normalgrid;

use Kitchen\News\Model\GalleryFactory;
use Kitchen\News\Model\ResourceModel\Gallery\CollectionFactory as CollectionFactory;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data as BackendHelper;
use Magento\Framework\Registry;

class Grid extends \Magento\Backend\Block\Widget\Grid\Extended
{
    protected $_galleryFactory;
    protected $_collectionFactory;
    protected $_coreRegistry;

    public function __construct(
        GalleryFactory $galleryFactory,
        CollectionFactory $collectionFactory,
        Context $context,
        BackendHelper $backendHelper,
        Registry $coreRegistry,
        array $data = []
    ) {
        $this->_coreRegistry = $coreRegistry;
        $this->_galleryFactory = $galleryFactory;
        $this->_collectionFactory = $collectionFactory;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setNewsId('news_id');
        $this->setDefaultSort('news_id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = $this->_galleryFactory->create()->getCollection();

        $collection->getSelect()->joinLeft(
            ['AT' => $collection->getTable('admin')], //2nd table name by which you want to join mail table
            'main_table.a_id = AT.admin_id', // common column which available in both table
            ['AT.admin_name'] // '*' define that you want all column of 2nd table. if you want some particular column then you can define as ['column1','column2']
        );

        $this->setCollection($collection);

        
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'news_id',
            [
                'header' => __('News ID'),
                'filter_index' => 'news_id',
                'index' => 'news_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );

        $this->addColumn(
            'news_title',
            [
                'header' => __('News Title'),
                'filter_index' => 'news_title',
                'index' => 'news_title',
                'type' => 'text',
                'truncate' => 50,
                'escape' => true
            ]
        );

        $this->addColumn(
            'news_desc',
            [
                'header' => __('News Description'),
                'filter_index' => 'news_desc',
                'index' => 'news_desc',
                'type' => 'text',
                'truncate' => 50,
                'sortable' => true,
                'escape' => true
            ]
        );

        $this->addColumn(
            'a_id',
            [
                'header' => __('Admin ID'),
                'filter_index' => 'a_id',
                'index' => 'a_id',
                'type' => 'text',
                'truncate' => 50,
                'escape' => true
            ]
        );

        $this->addColumn(
            'admin_name',
            [
                'header' => __('Admin Name'),
                'filter_index' => 'admin_name',
                'index' => 'admin_name',
                'type' => 'text',
                'truncate' => 50,
                'escape' => true
            ]
        );

        $this->addColumn(
            'is_active',
            [
                'header' => __('Status'),
                'type' => 'options',
                'index' => 'is_active',
                // 'filter' => \Kitchen\News\Block\Adminhtml\Normalgrid\Filter\IsActive::class
                // 'renderer' => \Magento\Review\Block\Adminhtml\Grid\Renderer\Type::class,
                'options' => ['0' => __('De-Active'), '1' => __('Active')]
            ]
        );

        $this->addColumn(
            'creation_time',
            [
                'header' => __('Created'),
                'type' => 'datetime',
                'filter_index' => 'creation_time',
                'index' => 'creation_time',
                'header_css_class' => 'col-date col-date-min-width',
                'column_css_class' => 'col-date'
            ]
        );

        $this->addColumn(
            'update_time',
            [
                'header' => __('Updated'),
                'type' => 'datetime',
                'filter_index' => 'update_time',
                'index' => 'update_time',
                'header_css_class' => 'col-date col-date-min-width',
                'column_css_class' => 'col-date'
            ]
        );
    
        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'type' => 'action',
                'getter' => 'getNewsId',
                'actions' => [
                    [
                        'caption' => __('Edit'),
                        'url' => ['base' => 'news1/normalgrid/edit'],
                        'field' => 'news_id'
                    ],
                    [
                        'caption' => __('Delete'),
                        'url' => ['base' => 'news1/normalgrid/delete'],
                        'field' => 'news_id',
                        'confirm' => [
                            'message' => __('Are you sure you want to delete this record?')
                        ]
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'news_id',
                'header_css_class' => 'col-action',
                'column_css_class' => 'col-action'
            ]
        );

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('news_id');
        $this->setMassactionIdFilter('news_id');
        $this->setMassactionIdFieldOnlyIndexValue(true);
        $this->getMassactionBlock()->setFormFieldName('news');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl(
                    'news1/normalgrid/massdelete',
                    ['ret' => $this->_coreRegistry->registry('usePendingFilter') ? 'pending' : 'index']
                ),
                'confirm' => __('Are you sure?')
            ]
        );

        // $statuses = $this->_reviewData->getReviewStatusesOptionArray();
        // array_unshift($statuses, ['label' => '', 'value' => '']);
        // $this->getMassactionBlock()->addItem(
        //     'update_status',
        //     [
        //         'label' => __('Update Status'),
        //         'url' => $this->getUrl(
        //             '*/*/massUpdateStatus',
        //             ['ret' => $this->_coreRegistry->registry('usePendingFilter') ? 'pending' : 'index']
        //         ),
        //         'additional' => [
        //             'status' => [
        //                 'name' => 'status',
        //                 'type' => 'select',
        //                 'class' => 'required-entry',
        //                 'label' => __('Status'),
        //                 'values' => $statuses,
        //             ],
        //         ]
        //     ]
        // );
    }

    protected function _prepareMassactionColumn()
    {
        parent::_prepareMassactionColumn();
        /** needs for correct work of mass action select functionality */
        $this->setMassactionIdField('news_id');

        return $this;
    }

    /**
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('news1/normalgrid/grid', ['_current' => true]);
    }

    /**
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('news1/normalgrid/edit', ['news_id' => $row->getId()]);
    }

}
