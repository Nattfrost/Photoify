const userPosts = JSON.parse(getCookie('userPosts'))
const container = document.querySelector('.posts-container')
console.table(userPosts)


userPosts.forEach((post) => {
	container.innerHTML += `
	<section class="user-item">
	<img class="user-image" src="${post.image}"/>
	<p>${post.description}</p>
	<p>${post.created_at}</p>
	</section>
	`
	})
