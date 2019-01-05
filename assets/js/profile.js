url = 'http://localhost:8888/app/posts/api.php'
const container = document.querySelector('.posts-container')

const  getUser = (name) => {
  var value = "; " + document.cookie
  var parts = value.split("; " + name + "=")
  if (parts.length == 2) return parts.pop().split(";").shift()
}


const createPost = (json) => {
	json.forEach((post) => {


		container.innerHTML += `
	<img class="avatar" src="${post.avatar}">
	<p>${post.username}</p>
	<section class="feed-item">
	<img class="feed-image" src="${post.image}"/>
	<p>${post.description}</p>
	<p>${post.created_at}</p>
	<form class="likes-form" action="../app/posts/likes.php" target="hiddenFrame" method="post">
		<button name="like" type="submit" data-id="${post.post_id}" class="like">like</button>
		<button name="dislike" type="submit" data-id="${post.post_id}" class="like">dislike</button>
		<p data-id="${post.post_id}" class="likes">${post.no_likes}</p>
	</form>
	</section>
	`
	})
}

const initEventListeners = (elts) => {
	elts.forEach(el => {
		el.addEventListener('click', handleClick)
	})
}

const handleClick = (event) => {
	let postId = event.target.dataset.id
	document.cookie = "like=" + postId
	setTimeout(() => {
		fetch(url)
			.then((resp) => resp.json())
			.then((data) => {
				const likes = [...document.querySelectorAll('.likes')]
				const filterfunc = data => data.filter(item => item.dataset.id === event.target.dataset.id)
				const dbfilter = data => data.filter(item => item.post_id === filterfunc(likes)[0].dataset.id)
				filterfunc(likes)[0].innerHTML = dbfilter(data)[0].no_likes
			})
	}, 40)
}

fetch(url)
	.then((resp) => resp.json())
	.then((data) => {
		if (window.location.pathname === '/profile.php') {
			let currentUser = getUser('user_id')
			 const userfilter = data => data.filter(user => user.user_id === currentUser)
				data = userfilter(data)
		}
		createPost(data)
		const buttons = document.querySelectorAll('.like')
		initEventListeners(buttons)
	})
