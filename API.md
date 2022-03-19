# Entities

## Quote

| Field     | Type   | Description |
|-----------|--------|-------------|
| id        | int    | Quote ID    |
| text      | string |             |
| timestamp | string |             |

## Search Query

| Entity    | Modifier | RegExp              |
|-----------|----------|---------------------|
| character | @        | `/[\d\wа-яё]{3,}/i` |
| tag       | #        | `/[\d\wа-яё]{3,}/i` |
| word      |          | `/[^\s]+/i`         |

| Query part | Value              |
|------------|--------------------|
| item       | {modifier}{entity} |
| delimiter  | :whitespace:       |

### Syntax

```
{item}{delimiter}{item}{delimiter}{item}...
```

### Example

Search Quotes with Characters `Alice` and `Bob` and with Tags `code`, `encryption` and with Words `need`, `help`

```
@Alice @Bob #code #encryption need help
```

# Requests

## Get Quote

### `/quotes/api/quote/get`

#### Request

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id    | int  | yes      | Quote ID    |

#### Response

[Quote Entity](#quote)

#### Throws

* Specify Exceptions
    * [IllegalArgumentException](#you-may-encounter-the-following-exceptions)
    * [NotFoundException](#you-may-encounter-the-following-exceptions)
* [Default Exceptions](#all-requests-throws)

#### Example

##### Request

```json
{
  "id": 1
}
```

##### Response

```json
{
  "id": 1,
  "text": "Hello everyone!",
  "timestamp": "2020-02-02 20:22:02"
}
```

## Get Quotes

### `/quotes/api/quote/get/list`

#### Request

| Field  | Type   | Required | Description                       |
|--------|--------|----------|-----------------------------------|
| index  | int    | no       | List Index                        |
| limit  | int    | no       | Maximum number of Quotes per List |
| search | string | no       | Search Query                      |

#### Response

| Field  | Type  | Description                               |
|--------|-------|-------------------------------------------|
| index  | int   | Page Index                                |
| limit  | int   | Maximum number of Quotes per List         |
| found  | int   | Number of Quotes found for a Search Query |
| quotes | array | Array of Quote Entities                   |

#### Throws

* [Default Exceptions](#all-requests-throws)

#### Example #1

##### Request

```json
{
  "index": 1,
  "search": "@Bob"
}
```

##### Response

```json
{
  "index": 1,
  "limit": 10,
  "found": 11,
  "quotes": [
    {
      "id": 5,
      "text": "Bob: Работа не волк. Работа - work, walk - гулять",
      "timestamp": "2020-02-02 20:22:02"
    }
  ]
}
```

#### Example #2

##### Request

```json
{
  "search": "@alice @bob eve kicked"
}
```

##### Response

```json
{
  "index": 0,
  "limit": 10,
  "found": 1,
  "quotes": [
    {
      "id": 50,
      "text": "Alice: Hello, Bob!\nEve: Bob: Hello!\n...\n* Eve kicked by Bob *\nBob: Hi!",
      "timestamp": "2020-02-02 20:22:02"
    }
  ]
}
```

## Add Quote

### `/quotes/api/quote/add`

#### Request

| Field | Type   | Required | Description |
|-------|--------|----------|-------------|
| text  | string | yes      | Quote Text  |

#### Response

[Quote Entity](#quote)

#### Throws

* Specify Exceptions
    * [IllegalArgumentException](#you-may-encounter-the-following-exceptions)
* [Default Exceptions](#all-requests-throws)

#### Example

##### Request

```json
{
  "text": "Не тот волк, кто не волк, а волк тот, кто волк"
}
```

##### Response

```json
{
  "id": 100,
  "text": "Не тот волк, кто не волк, а волк тот, кто волк",
  "timestamp": "2020-02-02 20:22:02"
}
```

## Update Quote

### `/quotes/api/quote/update`

#### Request

| Field | Type   | Required | Description |
|-------|--------|----------|-------------|
| id    | int    | yes      | Quote ID    |
| text  | string | yes      | New Text    |

#### Response

No response

#### Throws

* Specify Exceptions
    * [IllegalArgumentException](#you-may-encounter-the-following-exceptions)
    * [NotFoundException](#you-may-encounter-the-following-exceptions)
* [Default Exceptions](#all-requests-throws)

## Delete Quote

### `/quotes/api/quote/remove`

#### Request

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id    | int  | yes      | Quote ID    |

#### Response

No response

#### Throws

* Specify Exceptions
    * [IllegalArgumentException](#you-may-encounter-the-following-exceptions)
    * [NotFoundException](#you-may-encounter-the-following-exceptions)
* [Default Exceptions](#all-requests-throws)

# Responses

All responses are returned with 200 HTTP Status Code by default.<br>
In case of Exception it will return with equivalent HTTP Status Code.

# Exceptions

## Structure

| Field     | Type   | Description        |
|-----------|--------|--------------------|
| code      | int    | HTTP Status Code   |
| type      | string | Class of Exception |
| localized | string |                    |
| message   | string |                    |

```json
{
  "type": "EngineException",
  "localized": "",
  "message": ""
}
```

## You may encounter the following exceptions

| Exception                | Code | Localized                 | Description                                                           |
|--------------------------|------|---------------------------|-----------------------------------------------------------------------|
| EngineException          | 500  | Internal Engine Error     | It's parent exception, following exceptions are inherited from It     |
| UnexpectedException      |      | Unexpected Error          | All unexpected exceptions are wrapped in it                           |
| DbConnectionException    |      | Database Connection Error | Something happened to the database connection (eg. wrong credentials) |
| DbException              |      | Database Error            | Something happened to the database query                              |
| ConfirmException         |      | Confirmation Error        |                                                                       |
| LoginException           |      | Login Error               |                                                                       |
| SignupException          |      | Registration Error        |                                                                       |
| IllegalArgumentException | 400  | Illegal Argument          |                                                                       |
| NotFoundException        | 404  | Not Found                 |                                                                       |
| AccessDeniedException    | 403  | Access Denied             |                                                                       |

## All Requests throws

* [DbConnectionException](#you-may-encounter-the-following-exceptions)
* [DbException](#you-may-encounter-the-following-exceptions)
* [UnexpectedException](#you-may-encounter-the-following-exceptions)
