# vCard plugin for Craft CMS

vCard generator plugin for Craft

## Installation

To install vCard, follow these steps:

1. Download & unzip the file and place the `vcard` directory into your `craft/plugins` directory
2.  -OR- do a `git clone https://github.com/nfourtythree/craft-vcard.git` directly into your `craft/plugins` folder.  You can then update it with `git pull`
3. Install plugin in the Craft Control Panel under Settings > Plugins
4. The plugin folder should be named `vcard` for Craft to see it.  GitHub recently started appending `-master` (the branch name) to the name of the folder for zip file downloads.

vCard works on Craft 2.4.x and Craft 2.5.x.

## vCard Overview

This plugin generates a link to download a vCard from data you specify

## Configuring vCard

There is only one setting for this plugin which is `salt` this is a `string` used for salting the encoded data when generating the vCard link.

This is set randomly when the plugin is installed but can be changed to whatever you like.

## Using vCard

The only thing that is really `required` is first name. Everything else is optional

### Usage

There is a link variable available for usage in templates `craft.vCard.link(options)`

```

{% set options = {
	firstName: "Johnny",
	lastName: "Appleseed",
	additional: "Jim",
	prefix: "Mr",
	suffix: "Esq",
	company: "Apple Inc.",
	jobTitle: "Data Demo",
	email: [{ address: "johnny@apple.com", type: "WORK" }, "johnny@gmail.com"],
	url: "http://apple.com",
	phoneNumber: ["+1 234 567 89", { number: "+9 876 543 21"}],
	photo: "http://exmaple.com/images/avatar.jpg",
	address: [{
			name: "Apple",
			extended: "Suite 1",
			street: "1 Infinte Loop",
			city: "Cupertino",
			region: "CA",
			zip: "95014",
			country: "USA",
			type: "WORK;PARCEL;POSTAL"
		},
		{
			street: "1 Yemen Road",
			zip: "1234",
			country: "Yemen",
			type: "HOME;POSTAL"
		}],
	note: "Hi there",
} %}

<a href="{{ craft.vCard.link(options) }}">Download my vCard</a>

```


### Options

Name | Type | Example
--- | --- | ---
firstName | String | Johnny
lastName | String | Appleseed
additional | String | Jim (*commonly a middle name*)
prefix | String | Mr
suffix | String | Esq
company | String | Apple Inc
jobTitle | String | Demo Data Guru
email | String \| Array | [See email docs](#email)
url | String \| Array | [See url docs](#url)
address | String \| Array | [See address docs](#address)
phoneNumber | String \| Array | [See phoneNumber docs](#phonenumber)
birthday | String | 1985-10-26 (*YYYY-MM-DD format*)
note | String | Johnny is amazing
photo | String | http://example.com/images/avatar.jpg (*Url to image*)

---

##### email

This can be specified as either a string `johnny@apple.com` or an array (or even a mix!)

Name | Type | Example
--- | --- | ---
address | String | johnny@apple.com
type | String | type may be PREF | WORK | HOME or any combination of these: e.g. "PREF;WORK". This is not required


```
	email: {
		address: "johnny@apple.com",
		type: "WORK"
	}

	// For multiple email addresses
	email: [{
			address: "johnny@apple.com",
			type: "WORK"
		},
		{
			address: "johnny@gmail.com",
			type: "PREF;HOME"
		}]

	// Mix and match example
	email: ["johnny@apple.com", {
			address: "johnny@gmail.com",
			type: "PREF;HOME"
		}]


```

##### url

This can be specified as either a string `http://apple.com` or an array (or even a mix!)

Name | Type | Example
--- | --- | ---
address | String | http://apple.com
type | String | type may be WORK | HOME This is not required


```
	url: {
		address: "http://apple.com",
		type: "WORK"
	}

	// For multiple urls
	url: [{
			address: "http://apple.com",
			type: "WORK"
		},
		{
			address: "http://google.com",
			type: "HOME"
		}]

	// Mix and match example
	url: ["http://apple.com", {
			address: "http://google.com",
			type: "HOME"
		}]


```

##### phoneNumber

This can be specified as either a string `+1 234 567 89` or an array (or even a mix!)

Name | Type | Example
--- | --- | ---
number | String | +1 234 567 89
type | String | Type may be PREF | WORK | HOME | VOICE | FAX | MSG | CELL | PAGER | BBS | CAR | MODEM | ISDN | VIDEO or any sensible combination, e.g. "PREF;WORK;VOICE"


```
	phoneNumber: {
		number: "+1 234 567 89",
		type: "PREF;WORK;VOICE"
	}

	// For multiple phoneNumbers
	phoneNumber: [{
			number: "+1 234 567 89",
			type: "WORK"
		},
		{
			number: "+9 876 543 21",
			type: "PREF;HOME"
		}]

	// Mix and match example
	phoneNumber: ["+1 234 567 89", {
			number: "+9 876 543 21",
			type: "HOME"
		}]


```

##### address

This can be either a single or multi array

Name | Type | Example
--- | --- | ---
name | String | Apple
extended | String | Suite 1
street | String | 1 Infinte Loop
city | String | Cupertino
region | String | CA
zip | String | 95014
country | String | USA
type | String | type may be DOM | INTL | POSTAL | PARCEL | HOME | WORK or any combination of these: e.g. "WORK;PARCEL;POSTAL"

```
	address: {
		name: "Apple",
		extended: "Suite 1",
		street: "1 Infinte Loop",
		city: "Cupertino",
		region: "CA",
		zip: "95014",
		country: "USA",
		type: "WORK;PARCEL;POSTAL"
	}

	// For multiple addresses
	address: [{
			name: "Apple",
			extended: "Suite 1",
			street: "1 Infinte Loop",
			city: "Cupertino",
			region: "CA",
			zip: "95014",
			country: "USA",
			type: "WORK;PARCEL;POSTAL"
		},
		{
			street: "1 Yemen Road",
			zip: "1234",
			country: "Yemen",
			type: "HOME;POSTAL"
		}]

```

## ToDo

* Clean up / refactor code to tidy code that was done quickly

## vCard Changelog

### 1.0.1 -- 2016.02.23

* Fixed: Issue with vcard controller links creating 404s

### 1.0.0 -- 2016.02.16

* Initial release

Brought to you by [nfourtythree (n43.me)](http://n43.me)

###### Thanks to

- Jeroen Desloovere - https://github.com/jeroendesloovere/vcard
- nystudio107 - https://github.com/nystudio107/generator-craftplugin (for just making life easier / quicker)
- Chris Rowe - http://chrisrowe.net for the idea to make this plugin