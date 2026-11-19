# Choose Your Path

A branching text RPG built in PHP. Make a character, pick your way through four story chapters, fight three battles, and reach one of three endings.

## Setup

Requires PHP 7.4 or newer. No database and no packages to install.

1. Put all the project files in one folder.
2. From that folder run:
   ```
   php -S localhost:8000
   ```
3. Open `http://localhost:8000/login.php`.

With XAMPP (or similar), put the folder in `htdocs` and open `http://localhost/yourfolder/login.php`.

Accounts are stored in browser cookies, so a new browser has no accounts. Click "Create an account" first.

## Features

- Register and log in (passwords are hashed with `password_hash`)
- Progress is saved, so logging back in resumes on the page you left
- Character creation: name, class (Fighter, Mage, Knight) and race (Human, Elf, Dwarf), each changing your stats
- Four story chapters. Each choice changes the options in the next chapter
- Three turn based battles with Attack, Magic and Item (items are limited, you gain one per win)
- Score: 100 points per battle won
- Three endings (Good, Bad, Secret) picked by the final choice
- Leaderboard on the ending page, Play Again, and Try Again after a loss
- Dark game-style theme with sliding animations (`style.css`)

## Files

| File | Purpose |
|------|---------|
| `auth.php` | Shared login, session and resume helpers |
| `login.php`, `register.php`, `logout.php` | Accounts |
| `character.php` | Character creation |
| `story.php`, `story2.php`, `story3.php`, `story4.php` | Story chapters |
| `battle.php` | Battle logic and screen for all three fights |
| `ending.php` | Ending, score and leaderboard |
| `style.css` | Styling for every page |

## Tests

- Registering a new account lands on character selection
- Logging out and back in resumes on the last page
- Wrong password shows an error
- Visiting `story.php` while logged out redirects to login
- Each class and race starts a battle with different stats
- Winning a battle adds 100 score and one item; losing shows Game Over and Try Again restarts the fight
- Each of the three final choices reaches a different ending
- Play Again returns to character selection with the score reset

## In-app AI rule

The game has no AI features. All story, battle and scoring logic is plain PHP and runs without any AI service.

## Known limits

- Accounts and the leaderboard live in cookies and sessions, so they are per browser and the leaderboard only shows that account's runs
