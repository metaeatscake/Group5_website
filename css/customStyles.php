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
        border: 4px solid #ad5389;
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
        background-color: #ad5389;
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

  input[type="text"]:focus,
  input[type="password"]:focus,
  input[type="email"]:focus {
    border-color: purple;
    box-shadow: 0 0 8px 0 purple;
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
    color: purple;
  }

  .feed_post{
    margin:auto;
    text-align:left;
    width: 600px;
    min-height: 20%;
    color: black;
    background-color: white;
    padding: 15px;
    margin-top: 15px;
    border-radius: 8px;
  }

  .feed_title{
    text-align: left;
    font-weight: bold;
    font-size: 18px;
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
  }

  .feed_post_author{
    font-size: 14px;
    font-weight: lighter;
  }

  .feed_post_author a{
    text-decoration: none;
  }

  .feed_post_author a:hover{
    text-decoration: underline;
  }

  .feed_actions{
    width: 100%;
    display: inline-block;
    margin: 8px;
  }

  .feed_actions a{
    text-decoration: none;
    padding: 15px 83px;
    border: none;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
  }

  .feed_actions a:hover{
    border-radius: 5px;
    background-color: #cccccc;
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
    border: 4px solid #ad5389;
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
    background-color: #ad5389;
    color: white;
    box-shadow: 0 15px 45px rgba(24, 249, 141, 0.2);
  }
>>>>>>> 1d692c5b6b55cbaff12ae0c4371a9ab375d2155c
</style>
