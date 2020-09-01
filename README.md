# Team-248-Backend

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/ed53b2672d664cccb71fda0eb2a537f2)](https://app.codacy.com/gh/BuildForSDGCohort2/Team-248-Backend?utm_source=github.com&utm_medium=referral&utm_content=BuildForSDGCohort2/Team-248-Backend&utm_campaign=Badge_Grade_Settings)

## Endpoints

-   POST /api/offers

    Description: enables the user to create a new offer

    Headers:

-   Content-Type:application/json

-   Accept: application/json

    Body Parameters:

    For now the user_id is sent within the request until we decide on the authentication method

    ```javascript
    {
      "user_id":8,
      "category_id":8,
      "start_at":"2020-08-29 05:00:00",
      "end_at":"2020-08-29 06:00:00",
      "price_per_hour":100,
      "address":"Heliopolis"
    }
    ```

    Successful Response:

    Returns the inserted offer ID

    ```javascript
    {
        "message": "Offer created successfully.",
        "data": {
            "id": 51
        }
    }
    ```

    Failed Response:

    ```javascript
    {
        "message": "The given data was invalid.",
        "errors": {
            "user_id": [
                "The user id field is required."
            ],
            "category_id": [
                "The category id field is required."
            ],
            "start_at": [
                "The start at field is required."
            ],
            "end_at": [
                "The end at field is required."
            ],
            "price_per_hour": [
                "The price per hour field is required."
            ],
            "address": [
                "The address field is required."
            ]
        }
    }
    ```
