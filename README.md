# magento-slick-slider
Display multiple slick image sliders on few clicks.

In your layout .xml files or layout fields

```
<block type="slick_slider/slider" name="YOUR_SLIDER_NAME">
    <action method="setSliderSlug">
        <value>YOUR_SLIDER_SLUG</value>
    </action>
</block>
```

In your content editors or widgets

```
{{block type="slick_slider/slider" name="YOUR_SLIDER_NAME" slider_slug="YOUR_SLIDER_SLUG"}}
```

In your template .phtml files.

```
<?php 
    echo $this->getLayout()->createBlock('slick_slider/slider')->setSliderSlug('YOUR_SLIDER_NAME')->toHtml();
?>
```
