// ver 0.04


  // The width and height of the captured photo. We will set the
  // width to the value defined here, but the height will be
  // calculated based on the aspect ratio of the input stream.

  var width = 800;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  // |streaming| indicates whether or not we're currently streaming
  // video from the camera. Obviously, we start at false.

  var streaming = false;

  // The various HTML elements we need to configure or control. These
  // will be set by the startup() function.

  var video = null;
  var canvas = null;
  var photo = null;
  var startbutton = null;

  function startup() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    startbutton = document.getElementById('startbutton');

//	video = document.getElementById('video');
    video.style.width = '240px';
    video.style.height = '180px';
    video.setAttribute('autoplay', '');
    video.setAttribute('muted', '');
    video.setAttribute('playsinline', '');

	const vconstraints = {
        advanced: [{
            facingMode: "user"
        }]
    };
	
    var constraints = {
         audio: false,
		 video:  vconstraints
    }

    navigator.mediaDevices.getUserMedia(constraints).then(function success(stream) {
        video.srcObject = stream;
    });


    video.addEventListener('canplay', function(ev){
      if (!streaming) {
        height = video.videoHeight / (video.videoWidth/width);
      
        // Firefox currently has a bug where the height can't be read from
        // the video, so we will make assumptions if this happens.
      
        if (isNaN(height)) {
          height = width / (4/3);
        }
      
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);
        streaming = true;
      }
    }, false);

//    startbutton.addEventListener('click', function(ev){
//      takepicture();
//      ev.preventDefault();
//    }, false);

	 // $('#startbutton').click('takepicture()');
    clearphoto();
  }


  // Fill the photo with an indication that none has been
  // captured.

  function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    var data = canvas.toDataURL('image/png');
    photo.setAttribute('src', data);
  }
  
  $( "#retake" ).click(function() {
	$('#camera').show();
	$('#output').hide();
	$('#take_btns').show();
	$('#upl_btns').hide();
  });

//$('#uploadimg').click(function() {
//	var dataUrl = canvas.toDataURL();
//	$.ajax({
//		type: "POST",
//		url: "/poc-saveimg.php",
//		data: { 
//			imgBase64: dataUrl
//		}
//	}).done(function(msg) {
//		window.location.href = 'poc1a.php';
//	});
//});

  		

  // Capture a photo by fetching the current contents of the video
  // and drawing it into a canvas, then converting that to a PNG
  // format data URL. By drawing it on an offscreen canvas and then
  // drawing that to the screen, we can change its size and/or apply
  // other changes before drawing it.

  function takepicture() {
    var context = canvas.getContext('2d');
    if (width && height) {
      canvas.width = width;
      canvas.height = height;
      context.drawImage(video, 0, 0, width, height);
    
      var data = canvas.toDataURL('image/png');
      photo.setAttribute('src', data);
	  
	  $('#camera').hide();
	  $('#output').show();
	  $('#take_btns').hide();
	  $('#upl_btns').show();
    } else {
      clearphoto();
    }
  }



