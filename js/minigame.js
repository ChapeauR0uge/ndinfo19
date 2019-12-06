var inAir = true;
var isJumping = false;
var pos = {
  x:25,
  y:100,
};

var speed = {
  x:0,
  y:2,
};
var gravitation = 1.1;
var width = 100;
var height = 100;

var obstacle =
{
  width : 50,
  height : 100,
  x : 700,
  y : 400,
  speed : 6,
};

var img = new Image();
var imgspike = new Image();
var srcY = 0;
var step=0;
var score = 0;
function init(){

  window.requestAnimationFrame(draw);
}


function draw() {
  var canvas = document.getElementById('404game');
  if (canvas.getContext) {
    var ctx = canvas.getContext('2d');
    ctx.imageSmoothingEnabled = true;

    ctx.clearRect(0,0,canvas.width,canvas.height); // effacer le canvas
    img.src = "garcon2Sheet.png";
    imgspike.src = "pngkey.com-spike-png-2343253.png";
    ctx.drawImage(imgspike, obstacle.x, obstacle.y,obstacle.width,obstacle.height);
    var s= 30/12;
    ctx.drawImage(img, 64*Math.floor(step), srcY, 64,64, pos.x-12,pos.y-12, 64*s,64*s );
    //ctx.fillRect(pos.x, pos.y, width, height); //Dessiner le rectangle joueur
    //ctx.fillRect(obstacle.x,obstacle.y,obstacle.width,obstacle.height); //obstacle
    // ctx.clearRect(45, 45, 60, 60);
    //ctx.strokeRect(50, 50, 50, 50);

    ctx.font = '48px serif';
    ctx.fillText('Score :'+score, 10, 50);

    if(pos.y+height < canvas.height)
    {
      inAir = true;
    }

    if(inAir)
    {
      speed.y += 0.8;
      if(pos.y+height >= canvas.height)
      {
          speed.y = 0;
          inAir = false;
          isJumping = false;
          pos.y = canvas.height - height;
      }
    }
    else {
      document.addEventListener('keydown', function(e)
      {
        if(e.keyCode == 32 && !isJumping) //Barre espace
        {
          speed.y -= 20;
          isJumping = true;
        }
      });
    }
    pos.y += speed.y;
    obstacle.x -= obstacle.speed;
    if(obstacle.x+obstacle.width < 0)
    {
      obstacle.x = canvas.width;
      obstacle.speed += 0.2;
    }

    if(pos.x > obstacle.x-obstacle.width && pos.y+height > obstacle.y)
    {
      obstacle.x = canvas.width;
      obstacle.speed = 6;
      score=0;
    }
    else {
      score+=1;
    }

    srcY = 0;
 		step+=0.25;
 		if(step>=11)
 		{
 			step-=11;
 		}
    // console.log(speed.y+" | "+canvas.height);
    // console.log(inAir);

  window.requestAnimationFrame(draw);
}
}

init();
