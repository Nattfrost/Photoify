let url = 'http://localhost:8888/app/posts/full_api.php'
const container = document.querySelector('.posts-container')
// const commentSections = [...document.querySelectorAll('.comments-section')]

const getData = url => {
	return fetch(url)
		.then((resp) => resp.json())
}

const getUser = (name) => {
	var value = "; " + document.cookie
	var parts = value.split("; " + name + "=")
	if (parts.length == 2) return parts.pop().split(";").shift()
}

const initEventListeners = (elts, callback) => {
	elts.forEach(el => {
		el.addEventListener('click', callback)
	})
}

const handleClickLikes = (event) => {
	let postId = event.target.dataset.id
	document.cookie = "like=" + postId
	setTimeout(() => {
		getData(url)
			.then(data => {
				const likes = [...document.querySelectorAll('.likes')]
				const filterfunc = data => data.filter(item => item.dataset.id === event.target.dataset.id)
				const dbfilter = data => data.filter(item => item.post_id === filterfunc(likes)[0].dataset.id)
				filterfunc(likes)[0].innerHTML = 'likes: ' + dbfilter(data)[0].no_likes
			})
	}, 40)
}

const handleClickComment = (event) => {
	let postId = event.target.dataset.id
	document.cookie = "postId=" + postId
	setTimeout(() => {
		getData(url)
			.then(data => {
				const commentsSection = [...document.querySelectorAll('.comments-section')]
				const filterfunc = elts => elts.filter(el => el.dataset.id === postId)
				const dbfilter = data => data.filter(comments => comments.post_id === postId)

				dbfilter(data).forEach(comment => {
					filterfunc(commentsSection).forEach(commentSection => {
						console.log(commentSection)
						const postComments = comment.comments.map(postComment => {

							return `
							<p><b class="author">${postComment.author}:</b> ${postComment.content}</p>
							`
						}).join('')
						commentSection.innerHTML = postComments
					})
				})
			})
	}, 40)
}

const createPost = (json) => {
	let posts = json

	const postsMarkup = posts.map(post => {
		const comments = post.comments.map(comment => {
			return `<p><b class="author">${comment.author}:</b> ${comment.content}</p>`
		}).join('')
		return `
		<img class="avatar" src="${post.avatar}">
		<p>${post.username}</p>
		<section class="feed-item">
		<p class="description">${post.description}</p>
		<p class="created-at text-uppercase">${post.created_at}</p>
			<img class="feed-image" src="${post.image}" />
			<form class="likes-form" action="../app/posts/likes.php" target="hiddenFrame" method="post">
			<button name="like" type="submit" data-id="${post.post_id}" class="like like-button">like </button>
				<button name="dislike" type="submit" data-id="${post.post_id}" class="like dislike-button">dislike</button>
				<p data-id="${post.post_id}" class="likes">likes: ${post.no_likes}</p>
			</form>
			<div data-id="${post.post_id}" class="comments-container">
				<div class="comments-section" data-id="${post.post_id}">
					${comments}
				</div>
				<form class="comments-form" action="../app/posts/comments.php" target="hiddenFrame" method="post">
					<input type="text" name="comment" placeholder="" required>
					<button type="submit" data-id="${post.post_id}" class="comment-button">comment</button>
				</form>
			</div>
		</section>
		`
	}).join('')
	container.innerHTML = postsMarkup
}

getData(url)
	.then(data => {
		if (window.location.pathname === '/profile.php') {
			let currentUser = getUser('user_id')
			const userfilter = data => data.filter(user => user.user_id === currentUser)
			data = userfilter(data)
		}
		createPost(data)
		const buttons = document.querySelectorAll('.like')
		const commentButtons = [...document.querySelectorAll('.comment-button')]
		initEventListeners(buttons, handleClickLikes)
		initEventListeners(commentButtons, handleClickComment)
	})
