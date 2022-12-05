const express = require('express')
const { faker } = require('@faker-js/faker');

const app = express()
const port = 3000

// Get one company
app.get('/', (req, res) => {
	res.json(generate_companies(1));
});

// Get 'amount' companies
app.get('/:amount', (req, res) => {
	let amount = parseInt(req.params.amount);
	if (!Number.isInteger(amount) || amount <= 0) {
		res
			.status(400)
			.json({
				error: "400",
				message: "'amount' must be a valid positif integer"
			});

		return;
	}

	res.json(generate_companies(req.params.amount));
});

// Generate a list of random imaginary companies
function generate_companies(amount) {
	let companies = [];

	for (let i = 0; i < amount; ++i) {
		companies.push({
			name: faker.company.name(),
			catch_phrase: faker.company.catchPhrase()
		});
	}

	return companies;
}

// Start server
app.listen(port, () => {
	console.log(`Server listening on port ${port}`)
});

