<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Resource components
Major resource components supported by the Crossref API are:

- register
- user
- kost
- credits
- chat

These can be used alone like this

| resource      | description                       |
|:--------------|:----------------------------------|
| `/register`      | returns a list of user can register, 20 per page
| `/user`    | return a list of user active , 20 per page
| `/kost` | returns a list of all Crossref members (mostly publishers) |
| `/credits`      | returns a list of history of credits in user |
| `/chat`  | return a list of chat confersation



## Parameters

Parameters can be used to query, filter and control the results returned by the Crossref API. They can be passed as normal URI parameters or as JSON in the body of the request.

| parameter                    | description                 |
|:-----------------------------|:----------------------------|
| `q`                      | query terms |
| `rows={#}`                   | results per page |
| `offset={#}` (max 10k)               | result offset (use `cursor` for larger `/works` result sets)  |
| `sample={#}` (max 100)                | return random N results |
| `sort={#}`                   | sort results by a certain field |
| `order={#}`                  | set the sort order to `asc` or `desc` |


### Example query using URI parameters

    kost?q=global+state

## Queries

Free form search queries can be made, for example, works that include `renear` and `ontologies`:

    kost?query=ADINDA2

    
