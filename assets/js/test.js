let url = 'http://localhost:8888/app/posts/full_api.php'
const container = document.querySelector('.posts-container')
const hideLikeButtons = (json, elts) => json.map(post => {
	const buttons = elts.filter(el => el.dataset.id === post.post_id)
	if (post.has_liked) {
		buttons.map(button => {
			button.classList.toggle('hidden')

		})
	}

})

const createDeleteButtons = (elts) => {
	elts.map(el => {
		if (el.dataset.id !== getUser('user_id'))
			el.classList.add('hidden')

	})
}

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


				const likeButtons = [...document.querySelectorAll('.like-icon')]
				let currentbuttons = filterfunc(likeButtons)
				currentbuttons.map(button => {
					button.classList.toggle('hidden')
				})
			})
	}, 40)
}

const handleClickComment = (event) => {
	let postId = event.target.dataset.id
	document.cookie = "postId=" + postId
	// i should use async await
	setTimeout(() => {
		getData(url)
			.then(data => {
				const commentsSection = [...document.querySelectorAll('.comments-section')]
				const commentsInputs = [...document.querySelectorAll('.comments-input')]
				const filterfunc = elts => elts.filter(el => el.dataset.id === postId)
				const dbfilter = data => data.filter(comments => comments.post_id === postId)

				dbfilter(data).forEach(comment => {
					filterfunc(commentsSection).forEach(commentSection => {
						const postComments = comment.comments.map(postComment => {
							return `
							<p><b class="author">${postComment.author}:</b> ${postComment.content}</p>
							`
						}).join('')
						commentSection.innerHTML = postComments
						commentsInputs.forEach(commentInput => {
							commentInput.value = '';
						})
					})
				})
			})
	}, 20)
}
const handleClickDelete = (event) => {
	let postId = event.target.dataset.postid
	document.cookie = "delete=" + postId
	window.location.reload()
}
const createPost = (json) => {
	let posts = json
	const postsMarkup = posts.map(post => {
		const comments = post.comments.map(comment => {
			return `<p><b class="author">${comment.author}:</b> ${comment.content}</p>`
		}).join('')
		
		return `
<section class="feed-item">
	<form class="deletepost-form" target="hiddenFrame" action="../app/posts/update.php" method="post">
		<button name="deletepost" data-id="${post.user_id}" data-postid="${post.post_id}" class="delete-button" type="submit">Delete Toast</button>
	</form>
		<div class="image-wrapper">
		<img data-id="${post.post_id}" class="feed-image" src="${post.image}"/>
		</div>
	<div data-id="${post.post_id}" class="post-footer">

	<div class="likes-wrapper">
		<form class="likes-form hide-submit" action="../app/posts/likes.php" target="hiddenFrame" method="post">
			<label>
			<input name="like" type="submit" data-id="${post.post_id}" class="like like-button" />
			<svg data-id="${post.post_id}" class="like-icon" viewBox="0 0 60 60">
				<path d="M51.911 16.242c-.759-8.354-6.672-14.415-14.072-14.415-4.93 0-9.444 2.653-11.984 6.905-2.517-4.607-6.846-6.906-11.697-6.906C6.759 1.826.845 7.887.087 16.241c-.06.369-.606 2.311.442 5.478 1.078 4.568 3.568 8.723 7.199 12.013l18.115 16.439 18.426-16.438c3.631-3.291 6.121-7.445 7.199-12.014.748-3.166.502-5.108.443-5.477zm-2.39 5.019c-.984 4.172-3.265 7.973-6.59 10.985L25.855 47.481 9.072 32.25c-3.331-3.018-5.611-6.818-6.596-10.99-.708-2.997-.417-4.69-.416-4.701l.015-.101c.65-7.319 5.731-12.632 12.083-12.632 4.687 0 8.813 2.88 10.771 7.515l.921 2.183.921-2.183c1.927-4.564 6.271-7.514 11.069-7.514 6.351 0 11.433 5.313 12.096 12.727.002.016.293 1.71-.415 4.707z"/>
				<path d="M15.999 7.904c-5.514 0-10 4.486-10 10 0 .553.447 1 1 1s1-.447 1-1c0-4.411 3.589-8 8-8 .553 0 1-.447 1-1s-.448-1-1-1z"/>
				</svg>
			</label>
			<label>
				<input name="dislike" type="submit" data-id="${post.post_id}" class="like dislike-button" />
				<svg data-id="${post.post_id}" class="like-icon hidden" viewBox="0 0 60 60">
					<path d="M51.911 16.242c-.759-8.354-6.672-14.415-14.072-14.415-4.93 0-9.444 2.653-11.984 6.905-2.517-4.307-6.846-6.906-11.697-6.906C6.759 1.826.845 7.887.087 16.241c-.06.369-.306 2.311.442 5.478 1.078 4.568 3.568 8.723 7.199 12.013l18.115 16.439 18.426-16.438c3.631-3.291 6.121-7.445 7.199-12.014.748-3.166.502-5.108.443-5.477zM15.999 9.904c-4.411 0-8 3.589-8 8 0 .553-.447 1-1 1s-1-.447-1-1c0-5.514 4.486-10 10-10 .553 0 1 .447 1 1s-.448 1-1 1z"/>
				</svg>
			</label>
			<p data-id="${post.post_id}" class="likes">likes: ${post.no_likes}</p>
		</form>
		</div>
		<div class="author-container">

				<img class="avatar" src="${post.avatar}">
				<p class="post-author">${post.username} </p> 
				<p class="description">${post.description}</p>
				<p class="created-at text-uppercase">${post.timestamp}</p>
		
			<div data-id="${post.post_id}" class="comments-container">
			<div class="comments-section" data-id="${post.post_id}">
			${comments}
			</div>
			<form class="comments-form" action="../app/posts/comments.php" target="hiddenFrame" method="post">
				<input type="text" name="comment" placeholder="Add a comment.." class="comments-input" required/>
				<button type="submit" data-id="${post.post_id}" class="comment-button">comment</button>
			</form>
		</div>
		</div>
	
		</div>
</section>
`
	}).join('')

	container.innerHTML = postsMarkup
}

const showPostContent = (e) => {
	console.log(e.target)
	let postContents = [...document.querySelectorAll('.post-footer')]
	// currentPost = postContents.filter()
	postContents.map(postContent => {
		posts = postContent.dataset.id
		const current = posts => posts.filter(post => post.dataset.id === e.target.dataset.id)
		current(postContents)[0].setAttribute('style', 'display: flex')
	})
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
		const likeButtons = [...document.querySelectorAll('.like-icon')]
		const deleteButtons = [...document.querySelectorAll('.delete-button')]

		const commentButtons = [...document.querySelectorAll('.comment-button')]
		initEventListeners(buttons, handleClickLikes)
		initEventListeners(commentButtons, handleClickComment)
		initEventListeners(deleteButtons, handleClickDelete)
		hideLikeButtons(data, likeButtons)
		createDeleteButtons(deleteButtons)

		if (window.location.pathname === '/profile.php') {
			const postContents = [...document.querySelectorAll('.post-footer')]
			postContents.map(postContent => {
				postContent.setAttribute('style', 'display: none');
			})
			const profilePosts = [...document.querySelectorAll('.feed-image')]

			initEventListeners(profilePosts, showPostContent)

		}

	})
