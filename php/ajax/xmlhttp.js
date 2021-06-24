
function xml_likePost(postIdEnc, destinationURL){
  let xhr = new XMLHttpRequest();
  let postDiv = document.getElementById("p_"+postIdEnc);
  let div_like = postDiv.querySelector(".feed_actions > a");
  let div_like_children = div_like.children;

  xhr.onreadystatechange = function(){
    if(this.readyState == 4 && this.status == 200){
      //Debugging
      //alert(xhr.response);
      //location.reload();
      let returnedJSON = xhr.response;
      div_like.style.color = returnedJSON.color;
      div_like_children[1].innerText = returnedJSON.likeCount;

    }
  }
  xhr.responseType = 'json';
  xhr.open("GET", destinationURL ,true);
  xhr.send();
}

function xml_deletePost(dialogID, destinationURL){
  let dialog = document.getElementById(dialogID);

  //Alternative polyfill.
  if (! dialog.showModal) {
    dialogPolyfill.registerDialog(dialog);
  }

  //Show the popup box
  dialog.showModal();

  //Do nothing if cancel.
  dialog.querySelector('.close').addEventListener('click', function() {
    dialog.close();
  });

  //Do the deletion if accept.
  dialog.querySelector('.accept').addEventListener('click', function(){

    let xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function(){
      if(this.readyState == 4 && this.status == 200){

        //For debugging only.
        let returnval = xhr.response;
        //console.log(returnval);
        //alert(xhr.response.message);

        dialog.close();
        location.reload();
      }
    }
    xhr.responseType = 'json';
    xhr.open("GET", destinationURL ,true);
    xhr.send();

  });
}

function xml_submitEditPost(formID, handlerFileURL){
  let form = document.getElementById(formID);
  let formData = new FormData( form );
  let xhr = new XMLHttpRequest();

  form.addEventListener('submit', function(event){
    event.preventDefault();
    xhr.onreadystatechange = function(){
      let r = xhr.response;
      //Debugging.
      //alert(JSON.stringify(r));
      console.log(JSON.stringify(r));
      //document.location.href = "../";
    }
    xhr.responseType = 'json';
    xhr.open("POST", handlerFileURL, true);
    xhr.send(formData);
  })
}
