# COMP 3015 News

An article aggregrator.

## Running the application

Ensure an `articles.json` file is at the server root.

Run:

```
php -S localhost:9000 # or you could use a different port
```

Install Node (dev) dependencies:

```
npm i
```

Run the Node server for reloading CSS changes:

```
npm run dev
```

You can also run this using Apache or Nginx.

## Assumptions

During the development of the application, I assumed that a valid article title should be at least 3 characters in length. 
This assumption was made to ensure that titles are meaningful and descriptive.


## Difficulties

Implementing effective form of validation was challenging. Ensuring titles are of adequate length and URLs are valid 
demanded careful handling of various scenarios, including the empty scenarios. The solution involved a combination of 
PHP server-side validation and client-side validation for a smoother user experience.

Incorporating Tailwind CSS was another challenge. Setting up the build process, comprehending utility classes, 
and ensuring a consistent, responsive design required familiarity with Tailwind CSS. Overcoming these challenges 
involved referring to documentation and community resources.

