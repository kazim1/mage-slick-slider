# magento-slick-slider
Display multiple slick image sliders on few clicks.

**Features**
- Responsive Sliders
- Multiple Sliders on same page
- Fade and Slide Animation Options
- Easily customizable
- Multiple Store Support
- RTL Support

**Reference**
You can handle most of the important features of slick sliders. http://kenwheeler.github.io/slick/

You can call your sliders in different ways.

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
**Admin Panel Options**
**Slider**
![Alt text](/screenshots/slider.png?raw=true "Slider:")

**Slide**
![Alt text](/screenshots/slide.png?raw=true "Slide:")

**Frontend**
![Alt text](/screenshots/frontend.png?raw=true "Frontend:")
