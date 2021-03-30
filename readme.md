# System Proposal

## Website name

*Sociality*

## Type of website

*Social Media*

## Description

 Very social media website. \
 Almost like facebook except it is not as good.

 Features
1. Users can post not only text, but also images.
2. Users can like their posts and other users' posts.
3. Users can comment on their posts and other users' posts.
4. Enhanced CSS and responsive Web Design.


## Modules

### Basic Files
* #### database.php
  * Connection of PHP server to the Database
  * Database is named `socialitydb`
  * Tables used are: `tbl_users`, `tbl_feed`, `tbl_feed_likes`, and `tbl_comments`
* #### register.php
  * Allows the user to create an account for the website.
  * Requires a unique username and email
  * Password length must be 8 characters and above
  * The form must have these fields:
    * Username
    * Email
    * Sex
    * Password
    * Confirm Password
* #### handleRegister.php
  * Contains backend code for validating registration form input.
* #### login.php
  * A form that compares input with existing user data in the database.
  * When the user successfully logs in, they will be redirected back to the index page, where they will have access to the main features of the site.
  * Admins will be redirected to their own dashboard
* #### handleLogin.php
  * Backend code that validates form input and sets the core SESSION variables.
* #### index.php
  * The main landing page of guests and logged in users.
  * Will display a welcome card when not logged in.
  * Will display the feed when logged in as a user.

### Feature files
* #### profile.php
  * User will be able to view their profile here.
  * Contains a link that allows them to edit their profile.
  * They can also see their own posts.
* #### editProfile.php
  * Allows the user to edit their details
  * Allows them to set/edit their profile picture
  * Contains form validations.
* #### likedPosts.php
  * Displays all posts that the user has liked.
* #### logout.php
  * Allows users/admins to log out
  * Destroys the SESSION

### Admin Files
  * Not a priority feature of the website, but will have some form of implementation
    * adm_viewUsers.php
      * Display all registered users.
      * Allow admins to delete users.
    * adm_viewPosts
      * Allows admins to see all posts.
      * Allow admins to delete posts.
    * adm_addAdmins.php
      * Allows admins to register other admins.
      * Similar validation pattern as `register.php`
