url = 'http://localhost:8888/app/posts/full_api.php'

getData(url)
	.then(data => {
		console.log(data)
	})
