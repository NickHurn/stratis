'use strict';

var mediaSource = new MediaSource();
mediaSource.addEventListener('sourceopen', handleSourceOpen, false);
var mediaRecorder;
var recordedBlobs;
var sourceBuffer;

var gumVideo = document.querySelector('video#gum');
var recordedVideo = document.querySelector('video#recorded');

var recordButton = document.querySelector('button#record');
var playButton = document.querySelector('button#play');
var downloadButton = document.querySelector('button#download');
var saveButton = document.querySelector('button#save');
recordButton.onclick = toggleRecording;
playButton.onclick = play;
downloadButton.onclick = download;
saveButton.onclick = save;
var videoid = 0;
var videotype = 'answers';

const vconstraints = {
	advanced: [{
		facingMode: "user"
	}]
};
	
var constraints = {
  audio: true,
  video: vconstraints
};

function handleSuccess(stream) {
  recordButton.disabled = false;
  console.log('getUserMedia() got stream: ', stream);
  window.stream = stream;
  gumVideo.srcObject = stream;
}

function handleError(error) {
  console.log('navigator.getUserMedia error: ', error);
}

navigator.mediaDevices.getUserMedia(constraints).
    then(handleSuccess).catch(handleError);

function handleSourceOpen(event) {
  sourceBuffer = mediaSource.addSourceBuffer('video/mp4; codecs="mp4"');
}

recordedVideo.addEventListener('error', function(ev) {
  alert('Your browser can not play\n\n' + recordedVideo.src
    + '\n\n media clip. event: ' + JSON.stringify(ev));
}, true);

function handleDataAvailable(event) {
  if (event.data && event.data.size > 0) {
    recordedBlobs.push(event.data);
  }
}

function handleStop(event) {
  console.log('Recorder stopped: ', event);
}

function toggleRecording() {
  if (recordButton.textContent === 'Start Recording') {
    startRecording();
  } else {
    stopRecording();
    recordButton.textContent = 'Start Recording';
    playButton.disabled = false;
    downloadButton.disabled = false;
	saveButton.disabled = false;
  }
}

function startRecording() {
	$('#gum').show();
	$('#recorded').hide();
  recordedBlobs = [];
  var options = {mimeType: 'video/mpeg4'};
  if (!MediaRecorder.isTypeSupported(options.mimeType)) {
    options = {mimeType: 'video/webm;codecs=vp8'};
    if (!MediaRecorder.isTypeSupported(options.mimeType)) {
      options = {mimeType: 'video/webm;codecs=vp9'};
      if (!MediaRecorder.isTypeSupported(options.mimeType)) {
        options = {mimeType: ''};
      }
    }
  }
  try {
    mediaRecorder = new MediaRecorder(window.stream, options);
	//mediaRecorder.setVideoSize(640, 480);
	//mediaRecorder.setVideoFrameRate(16);
  } catch (e) {
    alert('Exception while creating MediaRecorder: '
      + e + '. mimeType: ' + options.mimeType);
    return;
  }
  recordButton.textContent = 'Stop Recording';
  $('#record').addClass("red");
  playButton.disabled = true;
  downloadButton.disabled = true;
  saveButton.disabled = true;
  mediaRecorder.onstop = handleStop;
  mediaRecorder.ondataavailable = handleDataAvailable;
  mediaRecorder.start(10); // collect 10ms of data
}

function stopRecording() {
  mediaRecorder.stop();
  recordedVideo.controls = true;
  $('#record').removeClass("red");
}

function play() {
  var superBuffer = new Blob(recordedBlobs, {type: 'video/mp4'});
  recordedVideo.src = window.URL.createObjectURL(superBuffer);
	$('#gum').hide();
	$('#recorded').show();
	recordedVideo.play();
}


function download() {
  //var blob = new Blob(recordedBlobs, {type: 'video/webm;codecs=vp8'});
  var blob = new Blob(recordedBlobs, {type: 'video/mp4;codecs=mp4'});
  var url = window.URL.createObjectURL(blob);
  var a = document.createElement('a');
  a.style.display = 'none';
  a.href = url;
  a.download = 'myanswer.webm';
  document.body.appendChild(a);
  a.click();
  setTimeout(function() {
    document.body.removeChild(a);
    window.URL.revokeObjectURL(url);
  }, 100);
}

function save()
{
	var oReq = new XMLHttpRequest();
	if(videotype=='answers')	oReq.open("POST", "/mediarecord/videoa/"+videoid, true);
	else						oReq.open("POST", "/mediarecord/videoq/"+videoid, true);
	oReq.onload = function (oEvent) {
		//window.location.href = 'somewhere';
		location.reload();
	};
	var blob = new Blob(recordedBlobs, {type: 'video/mp4;codecs=mp4'});
	oReq.send(blob);
}
