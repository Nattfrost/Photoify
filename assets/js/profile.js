url = 'http://localhost:8888/app/posts/api.php'
const container = document.querySelector('.posts-container')

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
	<p>${post.no_likes}</p>
	</form>
	</section>
	`
	})
}
const handleLikes = (e) => {

}
const initEventListeners = (elts) => {
	elts.forEach(el => {
		el.addEventListener('click', handleClick)
	})
}

const handleClick = (event) => {
let postId = event.target.dataset.id
document.cookie = "like="+postId;
}

fetch(url)
  .then((resp) => resp.json())
  .then((data) => {
			console.table(data)
   createPost(data)
			const buttons = document.querySelectorAll('.like')
			initEventListeners(buttons);
  })
