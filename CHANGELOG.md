# Changelog

## v0.2.9 - 2015-04-07

### Fixes

- Stricter email validation on User object

## v0.2.8 - 2015-03-19

### Additions

- User associations for use with third-party logins

## v0.2.7 - 2014-12-18

### Additions

- Add roles to User entity

## v0.2.6 - 2014-10-13

### Fixes

- Case-insenstive postcode validation

## v0.2.5 - 2014-10-10

### Additions

- Postcode validation on Personal Details

## v0.2.4 - 2014-10-08

### Fixes

- Allow PersonalDetails to be created with null Date of Birth

## v0.2.3 - 2014-10-02

### Fixes

- Always serialize a date of birth field in Personal Details

## v0.2.2 - 2014-10-01

### Additions

- Email address support in PersonalDetails entity

### Fixes

- Upped minimum stability for Composer dependencies

## v0.2.1 - 2014-09-24

### Additions

- Extra validation group for deleting a user

### Fixes

- Remove DateTimeInterface to maintain PHP 5.4 compatibility

## v0.2 - 2014-08-27

### Breakages

- Personal details moved from an assoc. array to a class
- Validation now contained in YAML file, not on the entities themselves

### Additions

- ID property on the User entity
- NullHasher to side-step password hashing in unit tests

### Fixes

- Password confirm property now included in User denormalization
- Standard timezones to stop user birthdays from moving back a day

## v1.0 - 2014-08-13

Initial tagged release.
