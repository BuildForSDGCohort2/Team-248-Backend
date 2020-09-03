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


<!-- START_a45eaa0bc07a2833fc15fdfb8cd32142 -->
## Create an offer

Enables the user to create a new offer

> Example request:

```bash
curl -X POST \
    "http://localhost/api/offers" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"user_id":4,"category_id":16,"start_at":"officia","end_at":"unde","price_per_hour":23.7447,"address":"et","preferred_qualifications":"sed"}'

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
    "user_id": 4,
    "category_id": 16,
    "start_at": "officia",
    "end_at": "unde",
    "price_per_hour": 23.7447,
    "address": "et",
    "preferred_qualifications": "sed"
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
    -d '{"user_id":12,"category_id":12,"start_at":"non","end_at":"ipsum","price_per_hour":1076.37,"address":"ut","preferred_qualifications":"sint"}'

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
    "user_id": 12,
    "category_id": 12,
    "start_at": "non",
    "end_at": "ipsum",
    "price_per_hour": 1076.37,
    "address": "ut",
    "preferred_qualifications": "sint"
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
    `user_id` | integer |  required  | the id of the user. It will be removed once the authentication implementation is merged.
        `category_id` | integer |  required  | the id of the offer category.
        `start_at` | datetime |  required  | the start date and time of the offer.
        `end_at` | datetime |  required  | the end date and time of the offer.
        `price_per_hour` | float |  required  | the price per hour offered.
        `address` | string |  required  | the address where the offer takes place.
        `preferred_qualifications` | string |  optional  | optional the address where the offer takes place.
    
<!-- END_d8ee1935637e83c8bfa5e3600a25f8c2 -->


