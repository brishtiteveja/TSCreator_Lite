<div id="mainContent">

<br />

<!-- <a href="<?php echo Path::get()->getWebPath('page_index') . '?load_defaults=true' ;?>">Generate New Chart</a> | -->
 <a href="<?php echo Path::get()->getWebPath('page_index');?>">Back to Chart Settings</a>  |

{chart_download,begin}
<a href="{*value}&as_download=true">Download PDF Chart</a>
{chart_download,end}

<style>
div.sticky 
{
  position: fixed;
  top: 0;
}
div.header 
{
  width: 8.2%;
  background: #fff4c8;
  padding: .01px 0;
  border:1px solid #ffcc00
  height: 1px
}
</style>

<div class="header">
<h3><a href="#" class="zin" style=display: inline;">
    <img src="images/zoomin.png">
    </a>
    <a href="#" class="zout" style=display: inline;">
    <img src="images/zoomout.png">
    </a>
    <a href="#" class="z100" style=display: inline;">
    <img src="images/zoom100.png">
    </a>
    <a href="#" class="zfit" style=display: inline;">
    <img src="images/zoomfit.png">
    </a>
    <a href="#" class="showline" style=display: inline;">
    <img src="images/showline.png">
    </a></h3>
</div>

<script>
var header = document.querySelector('.header');
var origOffsetY = header.offsetTop;
function onScroll(e) 
{
  window.scrollY >= origOffsetY ? header.classList.add('sticky') :
                                  header.classList.remove('sticky');
}

document.addEventListener('scroll', onScroll);
</script>


{pdf,begin}
<!-- PDF embeds suck in most browsers... <embed src="{*value}" width="100%" type="application/pdf" title="TSCLite Chart" /> -->
{pdf,end}

{png,begin}
<img class="chart noshow" src="{*value}" title="TSCLite Chart" id="chartObject" />
{png,end}

{svg,begin}
<object class="noshow" height="100%" width="100%" data="{*value}" type="image/svg+xml" id="SVGobject">
</object>
{svg,end}
<object class="noshow" height="100%" width="100%" data="/Chart.svg" type="image/svg+xml" id="SVGobject">
</object>


</div>
