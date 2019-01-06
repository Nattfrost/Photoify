url = 'http://localhost:8888/app/posts/full_api.php'

getData(url)
	.then(data => {
		let commentsArray = data.posts.length - 1;
		let comments = data.posts[commentsArray].comments
		let posts = data.posts

		console.log(data)
		console.log(posts)
		console.log(comments)
	})
