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
                          <label for="first">
                                Username:
                          </label>
                          <input type="text"
                                 id="first"
                                 name="first"
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
}
