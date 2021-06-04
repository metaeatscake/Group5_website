
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
