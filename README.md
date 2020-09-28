### RUN

1. `docker-compose up -d`

2. `composer install`

### Instructions

The goal of the exercise is to create a REST API that will handle two different resources :
- multiple-choice questions 
- choices related to a question
 
Only specific endpoints are required as part of this exercise and are described in the open-api.yaml file attached to this email.
 
The data is provided in a JSON and in a CSV file (both files are attached to this email). In order to remain flexible, your system must be able to handle both data sources (only one at a time and preferably configurable in the system) and be easily extendable to more in the future. For the purpose of this exercise, the data must remain in the JSON or CSV file and those files must serve as your database (do not import those data in an external database such as MySQL).
 
As described in the Open API file, one of the endpoints ([GET]/questions) provides a query parameter lang that allows the API client to request a translated version of the questions text field and associated choices text field. In order to provide the translation, please use Google Translate API (the library “stichoza/google-translate-php” is available on Packagist to ease the implementation).

### Expectations

As a general rule, we want to assess your skills in realistic conditions as you would have on the job. Therefore:
- You have the internet, use it!
- While the scope of the exercise is small, you need to consider this functionality is part of a bigger codebase with a lot of developers expected to understand and augment your code as easily as possible:
    - Readability: Think about how easy it will be for other developers to take over your code.
    - Flexibility/Generalisation: Functional requirements tend to change, data sources might be today a CSV file, tomorrow it might be a JSON or a MySQL database, maybe another REST web service. As a general rule, it is important to tackle broader flexibility than the strict requirement.
    - Robustness, things do not always go as expected, right?
- Reutilisation: A framework, A library a code snippet. Yes, you can reuse them as long as the re-used component is clearly highlighted to help us distinguishing your own code and re-used components. It is really up to you, maybe do it the way you would choose if this was a personal project.
 
As a general rule, we prefer to see a solid foundation start rather than a rushed working solution which do not meet the above conditions.
