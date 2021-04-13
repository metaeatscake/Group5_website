<style media="screen">

  .form-wrapper{
    width:400px;
  	margin:80px auto 0px auto;
  	padding:10px;
  	border-radius:5px;
  	-moz-border-radius:5px;
  	-webkit-border-radius:5px;
  	background-color:#fff;
  	overflow:auto;
    align-items: center;
  }

  label{
    font-family: "Roboto","Helvetica","Arial",sans-serif;
    font-size: 1.5rem;
  }

  .button{
    width:100px;
  	height:35px;
  	background-color:#ad5389;
  	color:#fff;
  	font-size:1.2em;
  	cursor:pointer;
  	float:right;
    display: inline-block;
    box-shadow: inset 0 0 0 0 #D80286;
    -webkit-transition: ease-out 0.4s;
    -moz-transition: ease-out 0.4s;
    transition: ease-out 0.4s;
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
    border-color: purple;
    box-shadow: 0 0 8px 0 purple;
  }

  input[type="password"]:focus {
    border-color: purple;
    box-shadow: 0 0 8px 0 purple;
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
    color: purple;
  }

  .formItem input[type="password"]:focus + i {
    color: purple;
  }

  .feed_post{
    margin:auto;
    text-align:left;
    width: 60%;
    font-family: Segoe UI;
    color:white;
    background: rgba(30,30,30,0.2);
    padding: 20px;
    margin-top: 30px;
  }

  .feed_title{
    text-align: left;
  }

  .feed_image{
    width:100%;
  }

  .feed_image img{
    width:100%;
    height:100%;
  }

  .feed_content{

  }

  .feed_post_time{

  }

  .feed_post_author{

  }

  #profile_pic{
    width: 150px;
    margin-top: -200px;
    border-radius: 50%;
    border: solid 2px white;
  }

  #profile-menu-buttons{
    width: 100px;
    display: inline-block;
    margin: 2px;
  }

  #following-img{
    width: 75px;
    float: left;
    margin: 8px;
  }

  #following-bar{
    background-color: white;
    min-height: 400px;
    margin-top: 20px;
    color: #aaa;
    padding: 8px;
  }
  
  #following{
    clear: both;
    font-size: 12px;
    font-weight: bold;
    color: #405d9b;
  }

</style>
