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

<!-- START_9f156b66d7daeebe829b03e4cf33a50f -->
## api/profile/updatePassword
> Example request:

```bash
curl -X PUT \
    "http://localhost/api/profile/updatePassword" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/profile/updatePassword"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`PUT api/profile/updatePassword`


<!-- END_9f156b66d7daeebe829b03e4cf33a50f -->

<!-- START_a45eaa0bc07a2833fc15fdfb8cd32142 -->
## Create an offer

Enables the user to create a new offer

> Example request:

```bash
curl -X POST \
    "http://localhost/api/offers" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"category_id":16,"start_at":"sit","end_at":"rerum","price_per_hour":90414.668923,"address":"eos","preferred_qualifications":"vel"}'

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
    "category_id": 16,
    "start_at": "sit",
    "end_at": "rerum",
    "price_per_hour": 90414.668923,
    "address": "eos",
    "preferred_qualifications": "vel"
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
    `category_id` | integer |  required  | the id of the offer category.
        `start_at` | datetime |  required  | the start date and time of the offer.
        `end_at` | datetime |  required  | the end date and time of the offer.
        `price_per_hour` | float |  required  | the price per hour offered.
        `address` | string |  required  | the address where the offer takes place.
        `preferred_qualifications` | string |  optional  | optional the address where the offer takes place.
    
<!-- END_a45eaa0bc07a2833fc15fdfb8cd32142 -->

<!-- START_2741c31dd89e5d192b39977e6ec69bb2 -->
## api/offers
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/offers" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/offers"
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
`GET api/offers`


<!-- END_2741c31dd89e5d192b39977e6ec69bb2 -->

<!-- START_d8ee1935637e83c8bfa5e3600a25f8c2 -->
## Update an offer

Enables the user to update an existing offer

> Example request:

```bash
curl -X PUT \
    "http://localhost/api/offers/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"category_id":13,"start_at":"voluptas","end_at":"libero","price_per_hour":666500.55,"address":"non","preferred_qualifications":"pariatur"}'

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
    "category_id": 13,
    "start_at": "voluptas",
    "end_at": "libero",
    "price_per_hour": 666500.55,
    "address": "non",
    "preferred_qualifications": "pariatur"
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

<!-- START_f7b14e58800200c9dd82259343ecea98 -->
## Delete an offer

Enables the user to delete an existing offer

> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/offers/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/offers/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Offer deleted successfully."
}
```

### HTTP Request
`DELETE api/offers/{offer}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the offer.

<!-- END_f7b14e58800200c9dd82259343ecea98 -->

<!-- START_1c3db579164b812f790141e36fb93fd7 -->
## Create an offer application

Enables the user to apply an offer

> Example request:

```bash
curl -X POST \
    "http://localhost/api/offers/1/apply" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/offers/1/apply"
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


> Example response (201):

```json
{
    "message": "Application created successfully.",
    "data": {
        "id": 1
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
> Example response (422):

```json
{
    "data": {
        "message": "This offer has already been approved.",
        "errors": ""
    }
}
```

### HTTP Request
`POST api/offers/{offer}/apply`


<!-- END_1c3db579164b812f790141e36fb93fd7 -->

<!-- START_1897f762d361886c099adb68e44342ed -->
## Cancel an application

Enables the user to cancel his application for an offer

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/applications/1/cancel" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/applications/1/cancel"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Application cancelled successfully.",
    "data": ""
}
```
> Example response (401):

```json
{
    "data": {
        "message": "This action is unauthorized.",
        "errors": ""
    }
}
```

### HTTP Request
`PATCH api/applications/{application}/cancel`


<!-- END_1897f762d361886c099adb68e44342ed -->

<!-- START_6d3061d375666b8cf6babe163b36f250 -->
## api/reset-password
> Example request:

```bash
curl -X POST \
    "http://localhost/api/reset-password" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/reset-password"
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
`POST api/reset-password`


<!-- END_6d3061d375666b8cf6babe163b36f250 -->

<!-- START_49efb800fa17a25dfa0396cdeaae588c -->
## api/user-offers
> Example request:

```bash
curl -X POST \
    "http://localhost/api/user-offers" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/user-offers"
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
`POST api/user-offers`


<!-- END_49efb800fa17a25dfa0396cdeaae588c -->

<!-- START_0111b45d14d4d7e802ec02d7c5670f1a -->
## Deactivate a user account

Enables the user to deactivate his account

> Example request:

```bash
curl -X PATCH \
    "http://localhost/api/users/deactivate" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/users/deactivate"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

fetch(url, {
    method: "PATCH",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "Account deactivated successfully.",
    "data": ""
}
```
> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```

### HTTP Request
`PATCH api/users/deactivate`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `user` |  required  | The ID of the user to be deactivated.

<!-- END_0111b45d14d4d7e802ec02d7c5670f1a -->

<!-- START_8685c256eacc0cca0fc32f11c8fd87ea -->
## api/applied-offers
> Example request:

```bash
curl -X POST \
    "http://localhost/api/applied-offers" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/applied-offers"
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
`POST api/applied-offers`


<!-- END_8685c256eacc0cca0fc32f11c8fd87ea -->

<!-- START_512ca1cc43ac8514662aba3aba6157db -->
## api/offers/{offer}
> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/offers/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/offers/1"
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


> Example response (404):

```json
{
    "message": "Resource not found.",
    "errors": ""
}
```

### HTTP Request
`GET api/offers/{offer}`


<!-- END_512ca1cc43ac8514662aba3aba6157db -->


