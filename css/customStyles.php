<style media="screen">

.form-wrapper{
  margin: 1em auto 0px;
  padding:25px;
  border-radius:5px;
  -moz-border-radius:5px;
  -webkit-border-radius:5px;
  background-color:#fff;
  background: -webkit-linear-gradient(to bottom, #fff 70%, #fff6e9);
  background: linear-gradient(to bottom, #fff 70%, #fff6e9);
  overflow:auto;
  align-items: center;
  float: left;
  margin-left: 100px;
  }

@media only screen and (max-width: 600px){
  .form-wrapper{
    width: 600px;
    height: 390px;
  }
}

@media only screen and (min-width: 600px){
  .form-wrapper{
    width: 500px;
    height: 390px;
  }
}

@media only screen and (min-width: 992px){
  .form-wrapper{
    width: 500px;
    height: 390px;
  }
}

@media only screen and (max-width: 768px){
  .form-wrapper{
    width: 500px;
    height: 340px;
    }
}

@media only screen and (min-width: 1200px){
  .form-wrapper{
    /*width: 495px;
    height: 400px;
    */  
    width: 450px;
    height: 301px;
  }
}

.form-wrapper-register{
  margin:5px auto 0px;
  padding:25px;
  border-radius:5px;
  -moz-border-radius:5px;
  -webkit-border-radius:5px;
  background-color:#fff;
  background: -webkit-linear-gradient(to bottom, #fff 20%, #fff6e9);
  background: linear-gradient(to bottom, #fff 20%, #fff6e9);
  overflow:auto;
  align-items: center;
  float: left;
  margin-left: 100px;
}

@media only screen and (min-width: 600px){
    .form-wrapper-register{
      width: 500px;
      height: 750px;
      margin-top: 50px;
      }
  }


@media only screen and (min-width: 992px){
  .form-wrapper-register{
    width: 800px;
    height: 710px;
    margin-top: 50px;
}

@media only screen and (max-width: 768px){
  .form-wrapper-register{
    width: 500px;
    height: 750px;
    margin-top: 50px;
    }
}

@media only screen and (min-width: 1200px){
  .form-wrapper-register{
    /*width: 800px;
    height: 710px;
    margin-top: 10px;*/

    width: 480px;
    height: 500px;
    margin-top: 10px;
  }
}

    label{
      font-family: "Roboto","Helvetica","Arial",sans-serif;
      font-size: 1.5rem;
    }

    .button:hover{
      box-shadow: inset 400px 0 0 0 #3c1053;
    }

    .input{
      background-color: transparent;
      width: 100%;
      border: 2px solid #aaa;
      border-radius: 4px;
      margin: 8px 0;
      outline: none;
      padding: 8px;
      box-sizing: border-box;
      transition: 0.3s;
      padding-left: 40px;
      }

      input[type="text"]:focus {
        border-color: #6148bf;
        box-shadow: 0 0 8px 0 #6148bf;
      }

      input[type="password"]:focus {
        border-color: #6148bf;
        box-shadow: 0 0 8px 0 #6148bf;
      }

      .formItem{
        position: relative;
      }

      .formItem input[type:text]{
        padding-left: 40px;
      }

      .formItem input[type:password]{
        padding-left: 40px;
      }

      .formItem i {
        position: absolute;
        left: 0;
        top: 8px;
        padding: 9px 8px;
        color: black;
        transition: 0.3s;
        font-size: 1.5rem;
        margin-left: 2px;
      }

      .formItem input[type="text"]:focus + i {
        color: #6148bf;
      }

      .formItem input[type="password"]:focus + i {
        color: #6148bf;
      }

      #gender{
        display: flex;
        height: 15vh;
        width: 20vw;
        margin: auto;
      }
      input[type="radio"]{
        -webkit-appearance: none;
      }
      #gender label{
        height: 100px;
        width: 150px;
        border: 4px solid #6148bf;
        position: relative;
        right: 6px;
        margin: auto;
        border-radius: 10px;
        transition: 0.5s;
      }

      #gender i{
        font-size: 40px;
        position: absolute;
        top: 50%;
        left: 47%;
        transform: translate(-50%, -80%);
      }
      #gender label>span{
        font-size: 20px;
        position: absolute;
        top: 80%;
        left: 49%;
        transform: translate(-50%, -80%);
      }
      #gender input[type="radio"]:checked + label{
        background-color: #6148bf;
        color: white;
        box-shadow: 0 15px 45px rgba(24, 249, 141, 0.2);
      }
  }

  label{
    font-family: "Roboto","Helvetica","Arial",sans-serif;
    font-size: 1.5rem;
  }

  .button{
    width:100px;
  	height:35px;
  	background-color: #6148bf;
  	color:#fff;
  	font-size:1.2em;
  	cursor:pointer;
  	float:right;
    display: inline-block;
    -webkit-transition: ease-out 0.4s;
    -moz-transition: ease-out 0.4s;
    transition: ease-out 0.4s;
    border-radius:  10px 10px 10px;
  }

  .button:hover{
    color: inset 400px 0 0 0 #3c1053;
  }

  .input{
    background-color: transparent;
    width: 100%;
    border: 2px solid #aaa;
    border-radius: 4px;
    margin: 8px 0;
    outline: none;
    padding: 8px;
    box-sizing: border-box;
    transition: 0.3s;
    padding-left: 40px;
  }

  input[type="text"]:focus,
  input[type="password"]:focus,
  input[type="email"]:focus {
    border-color: #6148bf;
    box-shadow: 0 0 8px 0 #6148bf;
  }

  .formItem{
    position: relative;
  }

  .formItem input[type:text],
  .formItem input[type:password]{
    padding-left: 40px;
  }

  .formItem i {
    position: absolute;
    left: 0;
    top: 8px;
    padding: 9px 8px;
    color: black;
    transition: 0.3s;
    font-size: 1.5rem;
    margin-left: 2px;
  }

  .formItem input[type="text"]:focus + i,
  .formItem input[type="password"]:focus + i,
  .formItem input[type="email"]:focus + i {
    color: #6148bf;
  }

  .feed_post{
    margin:auto;
    width: 39%;
    min-height: 20%;
    color: black;
    background-color: white;
    padding: 1.5%;
    margin-top: 1.5%;
    border-radius: 8px;
  }

  @media only screen and (min-width: 600px){
    .feed_post{
      width: 50%;
      min-height: 20%;
    }
  }

  @media only screen and (max-width: 600px){
    .feed_post{
      width: 50%;
      min-height: 20%;
    }
  }

  @media only screen and (min-width: 768px){
    .feed_post{
      width: 70%;
      min-height: 20%;
    }
  }

  @media only screen and (max-width: 992px){
    .feed_post{
      width: 90%;
      min-height: 20%;
    }
  }

  @media only screen and (min-width: 1200px){
    .feed_post{
      width: 32.3%;
      min-height: 20%;
    }
  }

  .more-horiz{
    float: right;
    position: relative;
    top: -1px;
    right: 8px;
    cursor: pointer;
  }

  .more-horiz:hover{
    background-color: #d9d9d9;
    border-radius: 50px;
    width: 40px;
  }

  .feed_userpic img{
    float: left;
    width: 50px;
    height: 50px;
    border-radius: 50px;
  }

  .feed_title{
    text-align: left;
    font-size: 18px;
    font-weight: bold !important;
  }

  .feed_image{
    width:100%;
  }

  .feed_image img{
    width:100%;
    height:100%;
  }

  .feed_content{
    font-size: 18px;
    font-weight: lighter;
  }

  .feed_post_time{
    font-size: 14px;
    font-weight: lighter;
    text-indent: 4px;
    position: relative;
    top: -10px;
  }

  .feed_post_time a{
    text-decoration: none;
    color: black;
  }

  .feed_post_time a:hover{
    text-decoration: underline;
  }

  .feed_post_author{
    font-size: 18px;
    font-weight: normal;
    text-indent: 4px;
  }

  .feed_post_author a{
    text-decoration: none;
    color: black;
  }

  .feed_post_author a:hover{
    text-decoration: underline;
  }

  .icon{
    position: relative;
    top: 5px;
    cursor: pointer;
  }

  .feed_actions{
    width: 45%;
    display: inline-flex;
    margin: -15px 10px;
  }

  .feed_actions a{
    padding: 5px 55px;
    margin-top: 12px;
    margin-left: auto;
    border: none;
    white-space: nowrap;
    align-content: space-evenly;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    text-decoration: none;
  }

  .feed_actions a:hover{
    border-radius: 5px;
    background-color: #cccccc;
  }

  @media only screen and (min-width: 600px){
    .feed_actions{
      width: 50%;
      min-height: 20%;
    }
  }

  @media only screen and (max-width: 600px){
    .feed_actions{
      width: 50%;
      min-height: 20%;
    }
  }

  @media only screen and (min-width: 768px){
    .feed_actions{
      width: 88%;
      min-height: 20%;
    }
  }

  @media only screen and (max-width: 992px){
    .feed_actions{
      width: 89%;
      min-height: 20%;
    }
  }

  @media only screen and (min-width: 1200px){
    .feed_actions{
      width: 89%;
      min-height: 20%;
    }
  }
  hr{
    display: block;
    height: 1px;
    border: 0;
    border-top: 1px solid #ccc;
    margin: 0.5em 0px;
    padding: 0;
  }

  #gender{
    display: flex;
    height: 15vh;
    width: 20vw;
    margin: auto;
  }
  input[type="radio"]{
    -webkit-appearance: none;
  }
  #gender label{
    height: 100px;
    width: 150px;
    border: 4px solid #6148bf;
    position: relative;
    right: 6px;
    margin: auto;
    border-radius: 10px;
    transition: 0.5s;
  }

  #gender i{
    font-size: 40px;
    position: absolute;
    top: 50%;
    left: 47%;
    transform: translate(-50%, -80%);
  }
  #gender label>span{
    font-size: 20px;
    position: absolute;
    top: 80%;
    left: 49%;
    transform: translate(-50%, -80%);
  }
  #gender input[type="radio"]:checked + label{
    background-color: #6148bf;
    color: white;
    box-shadow: 0 15px 45px rgba(24, 249, 141, 0.2);
  }

  /*DON'T UNCOMMENT THIS. IT BREAKS THE ALIGNMENT OF DIALOG.
  *{
  margin: 0;
  padding: 0;
} */

.footerSCL #footer_button{
  width:35px;
  height:35px;
  border: #727172 12px solid;
  border-radius:35px;
  margin-left: 100%;
  position: relative;
  -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;


}
.footerSCL #footer_button:hover{
  width:35px;
  height:35px;
  border: #3A3A3A 12px solid;
  -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;
  position:relative;
}
.footerSCL{
  bottom:0;
  left:0;
  position:fixed;
    width: 100%;
    height: 2em;
    overflow:hidden;
  -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;
  z-index:999;
}
.footerSCL:hover {
  -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    -o-transition: all 1s ease;
    -ms-transition: all 1s ease;
    transition: all 1s ease;
    height: 10em;
}
.footerSCL #footer_container{
  margin-top:5px;
  width:100%;
  height:100%;
  position:relative;
  top:0;
  left: 0;
  background: #f2f2f2;
  margin-left: 0%;
}


.footer_logo{
  margin-left: 20px;
  padding-top: 25px;
}

.footer_logo a{
  text-decoration: none;
  color: #696969;
  font-weight: bold;
}

.footer_logo a:hover{
  font-weight: bold;
  text-decoration: underline;
  text-underline-position: under;
  text-decoration-thickness: 2px;
  color: #3e1154;
}

.footer_logo img{
  padding-bottom: 10px;
}

.footer_logo i{
  font-size: 26px;
  height: 30px;
  margin-left: 20px;
}

.footer_logo li{
  float: right;
  display: inline;
  margin-right: 20px;
  padding-top: 7px;
  font-weight: bold;
}

.footer-list  li a{
  margin-bottom: 10px;
}
</style>
