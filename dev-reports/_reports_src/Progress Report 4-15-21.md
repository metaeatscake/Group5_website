Progress Report __April 15 2021__

Estimated site completion: **~77%**

Refer to April 14 report. Not much was accomplished today.

## Changes added:

* As recommended by Material Design Lite, Added the <dialog> polyfill for old browsers.
* Added UNIQUE Constraints and set up FOREIGN KEYs in the Database.
 * Considered using DEFAULT UUID_SHORT() instead of AutoIncrement Int as Primary key, but decided not to implement it.
* Added the template html to `viewPost.php`. Actual backend coding is expected to start tomorrow.

---
The current focus of development is `profile.php`. It was decided that the forms for editing
profile information is to be split into three forms - Edit Profile Picture and Banner,
Edit Bio, and Edit Account Details. This made `profile.php` more complex than originally planned.

---

The website will be considered 100% completed when:

* Profile.php is fully completed (including the editProfile setup and backend)
* View Post and Comment system is fully implemented
* The feature of viewing liked posts is finished, or integrated as a part of `profile.php`

The admin controls for the website is not a planned feature.
But it can be implemented as a Java CLI Application, separate from this project.