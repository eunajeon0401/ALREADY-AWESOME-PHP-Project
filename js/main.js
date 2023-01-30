function call_js(){
  let slideshowSlides = document.querySelector('.main_slideshow_poto');
  let slides = document.querySelectorAll('.main_slideshow_poto a');
  let prev = document.querySelector('.prev');
  let next = document.querySelector('.next');
  let indicators = document.querySelectorAll('.indicator a');
  let currentIndex = "";
  let timer = 0;
  let slideCount = slides.length;

  for(let i = 0; i <slides.length;i++){
    let newLeft = i * 100 + '%';
    slides[i].style.left = newLeft;
  }

  function gotoSlides(index){
    currentIndex = index;
    let newLeft = index * -100 + '%';
    slideshowSlides.style.left = newLeft;

    //한바퀴 돌때마다 하나씩 불러온다 
    indicators.forEach((obj)=>{
      obj.classList.remove('active');
    })

    indicators[index].classList.add('active');
  }

  function startTimer(){
    timer = setInterval(function(){
      let nextIndex = (currentIndex + 1) % slideCount;
      gotoSlides(nextIndex);
    },3000)
  }

  startTimer();

  slideshowSlides.addEventListener('mouseenter',()=>{
    clearInterval(timer);
  })

  slideshowSlides.addEventListener('mouseleave', ()=>{
    startTimer();
  })

  prev.addEventListener('mouseenter', ()=>{
    clearInterval(timer);
  })

  prev.addEventListener('click',(e)=>{
    e.preventDefault();
    currentIndex =currentIndex -1;
    if(currentIndex < 0){
      currentIndex = 2;
    }
    gotoSlides(currentIndex);
  })

  next.addEventListener('mouseenter', ()=>{
    clearInterval(timer);
  })

  next.addEventListener('click',(e)=>{
    e.preventDefault();
    currentIndex = currentIndex +1;
    if(currentIndex > 2){
      currentIndex = 0;
    }
    gotoSlides(currentIndex);
  })

  indicators.forEach((obj)=>{
    obj.addEventListener('mouseenter',()=>{
      clearInterval(timer);
    })
  })

  for(let i = 0; i <indicators.length; i++){
    indicators[i].addEventListener('click',(e)=>{
      e.preventDefault();
      gotoSlides(i);
    })
  }
}
