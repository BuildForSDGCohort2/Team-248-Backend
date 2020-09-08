---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.

<!-- END_INFO -->

#general


<!-- START_4dfafe7f87ec132be3c8990dd1fa9078 -->
## Return an empty response simply to trigger the storage of the CSRF cookie in the browser.

> Example request:

```bash
curl -X GET \
    -G "http://localhost/sanctum/csrf-cookie" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/sanctum/csrf-cookie"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET sanctum/csrf-cookie`


<!-- END_4dfafe7f87ec132be3c8990dd1fa9078 -->

<!-- START_d7b7952e7fdddc07c978c9bdaf757acf -->
## api/register
> Example request:

```bash
curl -X POST \
    "http://localhost/api/register" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/register`


<!-- END_d7b7952e7fdddc07c978c9bdaf757acf -->

<!-- START_c3fa189a6c95ca36ad6ac4791a873d23 -->
## api/login
> Example request:

```bash
curl -X POST \
    "http://localhost/api/login" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/login`


<!-- END_c3fa189a6c95ca36ad6ac4791a873d23 -->

<!-- START_61739f3220a224b34228600649230ad1 -->
## api/logout
> Example request:

```bash
curl -X POST \
    "http://localhost/api/logout" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/logout"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/logout`


<!-- END_61739f3220a224b34228600649230ad1 -->

<!-- START_2b6e5a4b188cb183c7e59558cce36cb6 -->
## api/user
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/user" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/user"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`GET api/user`


<!-- END_2b6e5a4b188cb183c7e59558cce36cb6 -->

<!-- START_a45eaa0bc07a2833fc15fdfb8cd32142 -->
## Create an offer

Enables the user to create a new offer

> Example request:

```bash
curl -X POST \
    "http://localhost/api/offers" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":7,"category_id":9,"start_at":"consequatur","end_at":"ut","price_per_hour":13093674.472,"address":"reprehenderit","preferred_qualifications":"qui"}'

```

```javascript
const url = new URL(
    "http://localhost/api/offers"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "user_id": 7,
    "category_id": 9,
    "start_at": "consequatur",
    "end_at": "ut",
    "price_per_hour": 13093674.472,
    "address": "reprehenderit",
    "preferred_qualifications": "qui"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Offer created successfully.",
    "data": {
        "id": 51
    }
}
```
> Example response (422):

```json
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

### HTTP Request
`POST api/offers`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `user_id` | integer |  required  | the id of the user. It will be removed once the authentication implementation is merged.
        `category_id` | integer |  required  | the id of the offer category.
        `start_at` | datetime |  required  | the start date and time of the offer.
        `end_at` | datetime |  required  | the end date and time of the offer.
        `price_per_hour` | float |  required  | the price per hour offered.
        `address` | string |  required  | the address where the offer takes place.
        `preferred_qualifications` | string |  optional  | optional the address where the offer takes place.
    
<!-- END_a45eaa0bc07a2833fc15fdfb8cd32142 -->

<!-- START_d8ee1935637e83c8bfa5e3600a25f8c2 -->
## Update an offer

Enables the user to update an existing offer

> Example request:

```bash
curl -X PUT \
    "http://localhost/api/offers/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"category_id":16,"start_at":"natus","end_at":"fugiat","price_per_hour":319.17886,"address":"non","preferred_qualifications":"provident"}'

```

```javascript
const url = new URL(
    "http://localhost/api/offers/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "category_id": 16,
    "start_at": "natus",
    "end_at": "fugiat",
    "price_per_hour": 319.17886,
    "address": "non",
    "preferred_qualifications": "provident"
}

fetch(url, {
    method: "PUT",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Offer updated successfully.",
    "data": {
        "id": 2
    }
}
```
> Example response (422):

```json
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
> Example response (404):

```json
{
    "message": "Resource not found.",
    "errors": ""
}
```

### HTTP Request
`PUT api/offers/{offer}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the offer.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `category_id` | integer |  required  | the id of the offer category.
        `start_at` | datetime |  required  | the start date and time of the offer.
        `end_at` | datetime |  required  | the end date and time of the offer.
        `price_per_hour` | float |  required  | the price per hour offered.
        `address` | string |  required  | the address where the offer takes place.
        `preferred_qualifications` | string |  optional  | optional the address where the offer takes place.
    
<!-- END_d8ee1935637e83c8bfa5e3600a25f8c2 -->


