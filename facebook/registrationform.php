<html>
      <h1>Sign Up for a New User</h1>
<?php
  //some code here
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
          <form action="addnewuser.php" method="POST" class="form login">
                Username:<input type="text" class="text_field" name="username" 
                required pattern="^[\w.-]+@[\w-]+(.[\w-]+)*$"
                title="Please Enter a Valid Email as Username"
                placeholder="Enter your Email Address" 
                onchange="this.setCustomValiditity(this.validity.patternMismatch?this.title: '');" /> <br>

                Password: <input type="password" class="text_field" name="password" 
                required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&])[\w!@#$%^&]{8,}$"
                placeholder="Enter your Password"
                title="Password must have at least 8 characters with 1 special symbol !@#$%^& 1 number, 1 
                lowercase and 1 UPPERCASE" 
                onchange="this.setCustomValiditity(this.validity.patternMismatch?this.title: '');
                form.repasword.pattern=this.value;"/> <br>

                Retype Password: <input type="password" class="text_field" name="retype"
                placeholder="Retype your Password" required title="Password does not Match"
                onchange="this.setCustomValiditity(this.validity.patternMismatch?this.title: '');" />
                <br>

                

              

                Email: <input type="text" class="text_field" name="emailid" required pattern="^[\w.-]+@[\w-]+(.[\w-]+)*$"
                title="PLease enter a valid Email"
                placeholder="Enter your Email Address" 
                onchange="this.setCustomValiditity(this.validity.patternMismatch?this.title: '');" /> <br>

                Phone: <input type="phone" class="text_field" name="phoneno" placeholder="Enter your Phone Number"/>
                <br>

              <p><button class="button" type="submit">
                  Sign Up
                </button> 

                <a href="form.php">Already a user go to Login</a></p>
          </form>
  </html>

