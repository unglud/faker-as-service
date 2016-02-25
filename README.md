# Faker as Service

[Faker](https://github.com/fzaninotto/faker) is a PHP library that generates fake data for you.
This service for easy generation of fake data in your sites. It supports Cross-Origin Resource Sharing, so you can also use it on frontend 

[Working service](http://faker.apus.ag)

## Usage

### As Hosted version

You can find the latest phar on the [releases page](https://github.com/bit3/faker-cli/releases).

```bash
curl -i -H “Accept: application/json” -H “Content-Type: application/json” -X GET https://faker.apus.ag?user_data=text%20500
```

```javascript
$.getJSON( “https://faker.apus.ag?user_data=text%20500”, 	function( data ) {console.log(data.data)}
```

### Parameters and arguments

```
?user_data=
 —locale (-l)    # The locale to used. (default: “en_US”)
 —seed (-s)      # The generators seed.
 —count (-c)     # The count of generated data. (default: 1)
 <type>          # The data type to generate (e.g. “randomDigit”, “words”, “name”, “city”)
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
http://faker.apus.ag?user_data=—count 5 words 2

culpa,consequatur
quisquam,recusandae
asperiores,accusammo
nihil,repelt
vero,omnia
```

## License

Faker Command Line Tool is released under the MIT Licence. See the bundled LICENSE file for details.