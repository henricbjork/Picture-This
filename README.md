<img src="https://media.giphy.com/media/oWi1ED7Sw22PK/source.gif" width="100%">

# Picture This
Instagram clone

## How to use  
- Clone or download this repository.
- Install PHP on your computer if you haven't
- Open up a PHP server within the directory and open the files in your browser.
- Make an account and have fun!

## Made with
- PHP
- Javascript
- HTML
- CSS

## Preview
<img width="350" alt="Screenshot 2020-01-13 at 21 49 31" src="https://user-images.githubusercontent.com/51784708/72290940-9d24b900-364e-11ea-85ea-770a0fb08e27.png"><img width="350" alt="Screenshot 2020-01-13 at 21 39 04" src="https://user-images.githubusercontent.com/51784708/72290803-4b7c2e80-364e-11ea-8b16-f5870eeceb69.png"><img width="349" alt="Screenshot 2020-01-13 at 21 49 15" src="https://user-images.githubusercontent.com/51784708/72290939-9c8c2280-364e-11ea-99fa-fbe23c4a05d4.png"><img width="350" alt="Screenshot 2020-01-13 at 21 40 32" src="https://user-images.githubusercontent.com/51784708/72290805-4b7c2e80-364e-11ea-98c7-f221171c257a.png">


## Extra added features
- As a user I should be able to follow and unfollow other users.
- As a user I should be able to view a list of posts by users I follow.

## Testers
- [Erik Johannesson](https://github.com/Erik-joh)
- [Betsy Alva Soplin](https://github.com/milliebase)

## License
MIT License

## Author
[Henric Björkvall](https://github.com/henricbjork)

## Code review
**Reviewer: <a href="https://github.com/Ljungblad">Victor Ljungblad</a>**

Overall, a very nice application! The project contain clean and readable code. I really like the redirect if you try to get access to somebody else posts when editing or to a post that does not exist.

**A few notes on the frontend:**
* When submitting a profile picture there’s no button to submit a file, only a text saying “Change profile picture”. Buttons makes it easier for user to know what to do ;)
* Might be a good idea to change the icon/color of the heart when liking a picture to easier see that you liked the picture.

**Comments**
- deletePost.php:10 - you’re declaring a variable, $userId, but are not using it after declaration.
- editPost.php:8 - you’re not validating and sanitizing the input data from $_POST[‘description’] with filter_var().
- editPost.php:27 - you’re not filtering the $_GET[‘id’] with filter_var(). You have to filter all input data from the frontend that the user can manipulate. This seem to be a repeatable thing throughout most of the form handling scripts in the app-folder.
- editPost.php - you don’t have a script that removes the old image from the uploads folder when editing post image. This tends to make the uploads folder very big in the long run. Try looking into the php-function unlink() to solve this problem.
- edit.php:137 - you should check if the submitted email exists in the database BEFORE you update the email in the database. As it is right now, you’ll always get an error message because $user[‘email’] will always be equal to the submitted email.
- functions.php:216 - Sometimes you’re not adding a description of the function as well as declaring whether the input and return value for a function is an integer, string, PDO etc. which you do for some functions. Keep your code consistent.
- edit.php - you don’t have a script that removes the old profile image from the uploads folder when changing profile image which tends to make the uploads folder very big in the long run.
- edit.php:151 - No need to repeat redirect('/edit.php’); two times after each other.
- register.php:23 - you’re using the same script from edit.php to check if the given email already exists. At this point it might be a good idea to create a function for it instead of repeating the same script.
- navigation.php:2 - Instead of using if (isset($_SESSION['user'])) on multiple pages you could add the script to a function called isLoggedIn which makes the code more clear and easier to read.
- profile.php:27-31 - Instead of using the same script in multiple files to display messages you could add this script to a file under views/ and use require wherever you want to display the message on the frontend. This makes the code much cleaner and easier to read.
- settings.php:1-3 - Instead of having separate php tags for each line of php code you could put all the code under the same php tag.

