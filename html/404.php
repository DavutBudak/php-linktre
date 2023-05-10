<?php header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found"); $url = 'https://'.$_SERVER['SERVER_NAME'].'/linktreclicksus/'; ?>
<style>
.down,.top{left:9vmin}*{margin:0;padding:0;box-sizing:border-box}body{overflow:hidden;background-color:#f4f6ff}.container{width:100%;height:100%;display:flex;justify-content:center;align-items:center;font-family:Poppins,sans-serif;position:relative;text-align:center}.button,.button span{cursor:pointer;display:inline-block;transition:.5s}.cog-wheel1,.cog-wheel2{transform:scale(.7)}.cog1,.cog2{width:40vmin;height:40vmin;border-radius:50%;border:6vmin solid #f3c623;position:relative}.down,.left,.left-down,.left-top,.right,.right-down,.right-top,.top{width:10vmin;height:10vmin;background-color:#f3c623;position:absolute}.button span,.cog2,.first-four,.second-four{position:relative}.cog2 .down,.cog2 .left,.cog2 .left-down,.cog2 .left-top,.cog2 .right,.cog2 .right-down,.cog2 .right-top,.cog2 .top{background-color:#4f8a8b}.top{top:-14vmin}.down{bottom:-14vmin}.left{left:-14vmin;top:9vmin}.right{right:-14vmin;top:9vmin}.left-top{transform:rotateZ(-45deg);left:-8vmin;top:-8vmin}.left-down,.right-top{transform:rotateZ(45deg)}.left-down{left:-8vmin;top:25vmin}.right-top{right:-8vmin;top:-8vmin}.right-down{transform:rotateZ(-45deg);right:-8vmin;top:25vmin}.cog2{border:6vmin solid #4f8a8b;left:-10.2vmin;bottom:10vmin}h1{color:#142833}.first-four{left:-2vmin;font-size:40vmin}.second-four{right:-2vmin;z-index:-1;font-size:40vmin}.wrong-para{font-family:Montserrat,sans-serif;position:absolute;bottom:15vmin;padding:3vmin 12vmin 3vmin 3vmin;font-weight:600;color:#092532}.button{border-radius:4px;background-color:#f4511e;border:none;color:#fff;text-align:center;font-size:28px;padding:20px;width:200px;margin:5px}.button span:after{content:'\00bb';position:absolute;opacity:0;top:0;right:-20px;transition:.5s}.button:hover span{padding-right:25px}.button:hover span:after{opacity:1;right:0}
</style>
<div class="container">
  <h1 class="first-four">4</h1>
  <div class="cog-wheel1">
      <div class="cog1">
        <div class="top"></div>
        <div class="down"></div>
        <div class="left-top"></div>
        <div class="left-down"></div>
        <div class="right-top"></div>
        <div class="right-down"></div>
        <div class="left"></div>
        <div class="right"></div>
    </div>
  </div>
  
 <h1 class="second-four">4</h1>
  <p class="wrong-para">ARADIĞINIZ SAYFA BULUNAMADI :(</p> 

  <div class="wrong-para" style="bottom:0vmin !important;">  <p><a href="<?php echo $url; ?>" class="button" style="vertical-align:middle"><span>ANASAYFA </span></a></p>
</div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.3.1/gsap.min.js"></script>
<script>
    let t1 = gsap.timeline();
let t2 = gsap.timeline();
let t3 = gsap.timeline();

t1.to(".cog1",
{
  transformOrigin:"50% 50%",
  rotation:"+=360",
  repeat:-1,
  ease:Linear.easeNone,
  duration:8
});

t2.to(".cog2",
{
  transformOrigin:"50% 50%",
  rotation:"-=360",
  repeat:-1,
  ease:Linear.easeNone,
  duration:8
});

t3.fromTo(".wrong-para",
{
  opacity:0
},
{
  opacity:1,
  duration:1,
  stagger:{
    repeat:-1,
    yoyo:true
  }
});
</script>