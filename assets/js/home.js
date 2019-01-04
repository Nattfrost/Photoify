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
	</section>
	`
	})
}

fetch(url)
  .then((resp) => resp.json())
  .then((data) => {
   createPost(data)
  })
