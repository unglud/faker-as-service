# Faker as Service

[Faker](https://github.com/fzaninotto/faker) is a PHP library that generates fake data for you.
This service for easy generation of fake data in your sites. It supports Cross-Origin Resource Sharing, so you can also use it on frontend 

[Working service](http://faker.apus.ag)

## Usage

### As Hosted version

```bash
curl -X GET http://faker.apus.ag\?user_data\=text%20500
```

```javascript
$.getJSON("http://faker.apus.ag?user_data=text%20500", 	function( data ) {console.log(data)})
```

### Parameters and arguments

```
?user_data=
 --locale    # The locale to used. (default: “en_US”)
 --seed      # The generators seed.
 --count     # The count of generated data. (default: 1)
 <type>     # The data type to generate (e.g. “randomDigit”, “words”, “name”, “city”)
 <args1>..<argsN> # Arguments for the type, e.g. “words 5” will generate 5 words.
```

### Single value generator example

```
http://faker.apus.ag?user_data=word

culpa
consequatur
quisquam
recusandae
asperiores
accusamus
nihil
repelt
vero
omnis
```

### Multi value generator example

```
http://faker.apus.ag?user_data=--count 5 words 2

culpa,consequatur
quisquam,recusandae
asperiores,accusammo
nihil,repelt
vero,omnia
```

## License

Faker Command Line Tool is released under the MIT Licence. See the bundled LICENSE file for details.
