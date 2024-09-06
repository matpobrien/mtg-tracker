<?php

class LoginTemplate
{
    public function __construct() {}
    
    public function renderLoginForm(): string
    {
        return <<<HTML
            <html lang="">
                <head>
                    <title>MTG Tracker Login</title>
                </head>
                
               <body>
                    <h3>Enter your login credentials</h3>
                    <form action="">
                          <label for="username">
                                Username:
                          </label>
                          <input type="text"
                                 id="username"
                                 name="username"
                                 placeholder="Enter your Username" required>
        
                          <label for="password">
                                Password:
                          </label>
                          <input type="password"
                                 id="password"
                                 name="password"
                                 placeholder="Enter your Password" required>
        
                          <div class="wrap">
                                <button name="login" type="submit" formmethod="post" value="Login">
                                      Login
                                </button>
                          </div>
                    </form>
               </body>
            </html>
        HTML;
    }
    
    public function renderSignupForm(): string
    {
        return <<<HTML
            <html lang="">
                <head>
                    <title>MTG Tracker Signup</title>
                </head>
                
               <body>
                    <h3>Enter your desired credentials</h3>
                    <form action="">
                          <label for="username">
                                Username:
                          </label>
                          <input type="text"
                                 id="username"
                                 name="username"
                                 placeholder="Enter your Username" required>
        
                          <label for="password">
                                Password:
                          </label>
                          <input type="password"
                                 id="password"
                                 name="password"
                                 placeholder="Enter your Password" required>
        
                          <div class="wrap">
                                <button name="signup" type="submit" formmethod="post" value="Signup">
                                      Login
                                </button>
                          </div>
                    </form>
               </body>
            </html>
        HTML;
    }
    
    public function renderSignoutButton()
    {
        return
            <<<HTML
                <button name="signout" type="submit" formmethod="post" value="signout">
                Signout
                </button>
            HTML;
    }
}
