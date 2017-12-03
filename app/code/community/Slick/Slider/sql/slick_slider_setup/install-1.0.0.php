<?php
/**
 * Slick_Slider extension
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the MIT License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/mit-license.php
 * 
 * @category       Slick
 * @package        Slick_Slider
 * @copyright      Copyright (c) 2017
 * @license        http://opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Slider module install script
 *
 * @category    Slick
 * @package     Slick_Slider
 * @author      Ali Kazim
 */
$this->startSetup();
$table = $this->getConnection()
    ->newTable($this->getTable('slick_slider/slider'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Slider ID'
    )
    ->addColumn(
        'name',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Name'
    )
    ->addColumn(
        'slug',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Slug'
    )
    ->addColumn(
        'slides_to_show',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned'  => true,
        ),
        'Slides To Show'
    )
    ->addColumn(
        'slides_to_scroll',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned'  => true,
        ),
        'Slides To Scroll'
    )
    ->addColumn(
        'center_mode',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Center Mode'
    )
    ->addColumn(
        'show_dots',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Show Dots'
    )
    ->addColumn(
        'show_arrows',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Show Arrows'
    )
    ->addColumn(
        'speed',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned'  => true,
        ),
        'Speed'
    )
    ->addColumn(
        'rtl',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'RTL'
    )
    ->addColumn(
        'infinite',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Infinite'
    )
    ->addColumn(
        'class',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Style Class'
    )
    ->addColumn(
        'spacing',
        Varien_Db_Ddl_Table::TYPE_INTEGER, 10,
        array(
            'nullable'  => false,
        ),
        'Spacing'
    )
    ->addColumn(
        'center_padding',
        Varien_Db_Ddl_Table::TYPE_INTEGER, 10,
        array(
            'nullable'  => false,
        ),
        'Center Padding'
    )
    ->addColumn(
        'fade',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Fade'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Enabled'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Slider Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Slider Creation Time'
    )
    ->addIndex($this->getIdxName('slick_slider/slider', array('slug')), array('slug'))
    ->setComment('Slider Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('slick_slider/slide'))
    ->addColumn(
        'entity_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER,
        null,
        array(
            'identity'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Slide ID'
    )
    ->addColumn(
        'slider_id',
        Varien_Db_Ddl_Table::TYPE_INTEGER, null,
        array(
            'unsigned'  => true,
        ),
        'Slider ID'
    )
    ->addColumn(
        'title',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Title'
    )
    ->addColumn(
        'image',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Image'
    )
    ->addColumn(
        'video',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Video'
    )
    ->addColumn(
        'poster',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Video Poster'
    )
    ->addColumn(
        'content',
        Varien_Db_Ddl_Table::TYPE_TEXT, '64k',
        array(),
        'Content'
    )
    ->addColumn(
        'link',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(),
        'Link'
    )
    ->addColumn(
        'class',
        Varien_Db_Ddl_Table::TYPE_TEXT, 255,
        array(
            'nullable'  => false,
        ),
        'Style Class'
    )
    ->addColumn(
        'status',
        Varien_Db_Ddl_Table::TYPE_SMALLINT, null,
        array(),
        'Enabled'
    )
    ->addColumn(
        'updated_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Slide Modification Time'
    )
    ->addColumn(
        'created_at',
        Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
        null,
        array(),
        'Slide Creation Time'
    ) 
    ->addIndex($this->getIdxName('slick_slider/slider', array('slider_id')), array('slider_id'))
    ->setComment('Slide Table');
$this->getConnection()->createTable($table);
$table = $this->getConnection()
    ->newTable($this->getTable('slick_slider/slide_store'))
    ->addColumn(
        'slide_id',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        array(
            'nullable'  => false,
            'primary'   => true,
        ),
        'Slide ID'
    )
    ->addColumn(
        'store_id',
        Varien_Db_Ddl_Table::TYPE_SMALLINT,
        null,
        array(
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ),
        'Store ID'
    )
    ->addIndex(
        $this->getIdxName(
            'slick_slider/slide_store',
            array('store_id')
        ),
        array('store_id')
    )
    ->addForeignKey(
        $this->getFkName(
            'slick_slider/slide_store',
            'slide_id',
            'slick_slider/slide',
            'entity_id'
        ),
        'slide_id',
        $this->getTable('slick_slider/slide'),
        'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addForeignKey(
        $this->getFkName(
            'slick_slider/slide_store',
            'store_id',
            'core/store',
            'store_id'
        ),
        'store_id',
        $this->getTable('core/store'),
        'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE,
        Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('Slides To Store Linkage Table');
$this->getConnection()->createTable($table);
$this->endSetup();
