<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>The Art of Empathy Gallery</title>
<style>
  /* Your CSS from before (navbar + gallery + modal + form + background) */

  body {
    margin: 0;
    font-family: 'Inter', sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: #f0f0f5;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 2rem;
  }
  /* Navbar styles */
.navbar {
  position: fixed;
  top: 0;
  width: 100%;
  background: linear-gradient(90deg, #5e4a9f, #4b2e83);
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  z-index: 1000;
  box-shadow: 0 6px 15px rgba(75, 46, 131, 0.5);
  backdrop-filter: saturate(180%) blur(8px);
  font-weight: 600;
  letter-spacing: 0.8px;
  font-size: 1rem;
  transition: background 0.3s ease;
}

.navbar:hover {
  background: linear-gradient(90deg, #6c63ff, #4b2e83);
  box-shadow: 0 8px 20px rgba(108, 99, 255, 0.6);
}

.logo {
  font-size: 2.2rem;
  font-weight: 900;
  background: linear-gradient(45deg, #ffcc70, #6c63ff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  cursor: default;
  user-select: none;
  letter-spacing: 2px;
  transition: transform 0.3s ease;
}

.logo:hover {
  transform: scale(1.1);
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 30px;
  margin: 0;
  padding: 0;
}

.nav-links a {
  color: #fefefe;
  text-decoration: none;
  font-size: 1.1rem;
  font-weight: 600;
  position: relative;
  padding-bottom: 5px;
  transition: color 0.3s ease;
}

.nav-links a::after {
  content: "";
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background: #ffcc70;
  transition: width 0.3s ease;
}

.nav-links a:hover {
  color: #ffcc70;
}

.nav-links a:hover::after {
  width: 100%;
}
/* Navbar styles */
.navbar {
  position: fixed;
  top: 0;
  width: 100%;
  background: linear-gradient(90deg, #5e4a9f, #4b2e83);
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 15px 40px;
  z-index: 1000;
  box-shadow: 0 6px 15px rgba(75, 46, 131, 0.5);
  backdrop-filter: saturate(180%) blur(8px);
  font-weight: 600;
  letter-spacing: 0.8px;
  font-size: 1rem;
  transition: background 0.3s ease;
}

.navbar:hover {
  background: linear-gradient(90deg, #6c63ff, #4b2e83);
  box-shadow: 0 8px 20px rgba(108, 99, 255, 0.6);
}

.logo {
  font-size: 2.2rem;
  font-weight: 900;
  background: linear-gradient(45deg, #ffcc70, #6c63ff);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  cursor: default;
  user-select: none;
  letter-spacing: 2px;
  transition: transform 0.3s ease;
}

.logo:hover {
  transform: scale(1.1);
}

.nav-links {
  list-style: none;
  display: flex;
  gap: 30px;
  margin: 0;
  padding: 0;
}

.nav-links a {
  color: #fefefe;
  text-decoration: none;
  font-size: 1.1rem;
  font-weight: 600;
  position: relative;
  padding-bottom: 5px;
  transition: color 0.3s ease;
}

.nav-links a::after {
  content: "";
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background: #ffcc70;
  transition: width 0.3s ease;
}

.nav-links a:hover {
  color: #ffcc70;
}

.nav-links a:hover::after {
  width: 100%;
}
  h1, h2 {
    text-align: center;
    color: #ffcc70;
  }

  /* Gallery styles */
  #gallery {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(180px,1fr));
    gap: 20px;
    margin-bottom: 2rem;
  }

  .gallery-item {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    overflow: hidden;
    cursor: pointer;
    transition: transform 0.3s ease;
    outline: none;
  }
  .gallery-item:focus,
  .gallery-item:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(255, 204, 112, 0.7);
  }

  .gallery-item img {
    max-width: 100%;
    height: 120px;
    object-fit: cover;
    display: block;
  }

  .caption {
    padding: 8px 12px 4px;
    font-weight: 700;
    color: #ffcc70;
    font-size: 1.1rem;
    text-align: center;
  }

  .quote {
    font-style: italic;
    padding: 0 12px 12px;
    font-weight: 600;
    font-size: 0.9rem;
    color: #eee;
    min-height: 60px;
  }

  /* Modal */
  #modal {
    display: none;
    position: fixed;
    z-index: 2000;
    left: 0; top: 0; width: 100%; height: 100%;
    background-color: rgba(0,0,0,0.8);
    align-items: center;
    justify-content: center;
  }
  #modal:focus {
    outline: none;
  }
  #modal-content {
    max-width: 90%;
    max-height: 80%;
    border-radius: 12px;
    box-shadow: 0 0 40px #ffcc70cc;
    background: #222;
    padding: 1rem;
    text-align: center;
    color: #ffcc70;
  }
  #modal img {
    max-width: 100%;
    max-height: 60vh;
    border-radius: 8px;
    margin-bottom: 1rem;
  }
  #modal-caption {
    font-size: 1.1rem;
  }
  #modal-close {
    position: absolute;
    top: 15px;
    right: 30px;
    font-size: 2rem;
    color: #ffcc70;
    cursor: pointer;
    user-select: none;
  }

  /* Submission Form */
  form {
    background: rgba(0,0,0,0.15);
    padding: 1.5rem 2rem;
    border-radius: 16px;
    box-shadow: inset 0 0 20px #00000055;
    margin-top: 2rem;
  }
  form h2 {
    margin-bottom: 1rem;
    color: #fff;
  }
  form label {
    display: block;
    margin-top: 1rem;
    font-weight: 600;
    color: #ffcc70;
  }
  form input[type="text"],
  form select,
  form textarea {
    width: 100%;
    padding: 0.6rem;
    margin-top: 0.3rem;
    border-radius: 8px;
    border: none;
    font-size: 1rem;
    font-family: inherit;
  }
  form textarea {
    resize: vertical;
    min-height: 80px;
  }
  form button {
    margin-top: 1.5rem;
    background: #5f3dc4;
    color: white;
    border: none;
    padding: 0.7rem 1.6rem;
    font-size: 1.1rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    box-shadow: 0 4px 15px #4c32a6cc;
    transition: background-color 0.3s ease, box-shadow 0.3s ease;
  }
  form button:hover {
    background: #7b56e1;
    box-shadow: 0 6px 20px #7b56e1cc;
  }
  /* Add this to your <style> section */
main.container {
  margin-top: 90px; /* Adjust to match your navbar height */
}
/* Add this to your <style> section */
main.container {
  margin-top: 90px; /* Adjust to match your navbar height */
}
</style>
</head>
<body>

  
<nav class="navbar">
  <div class="logo">Empathy Simulator</div>
  <ul class="nav-links">
    <li><a href="empathy_simulator.php">Empathy Simulator</a></li>
    <li><a href="empathy_quiz.php">Empathy Quiz or Test</a></li>
    <li><a href="anonymous_advice_wall.php">Anonymous Advice Wall</a></li>
    <li><a href="art_gallery.php">Empathy Art</a></li>
  
  </ul>
</nav>
  


<main class="container" role="main" tabindex="-1">

  <h1>The Art of Empathy Gallery</h1>
  <p style="text-align:center; margin-bottom: 2rem; font-size:1.1rem; color:#dcdcdcaa;">
    Explore art, photos, and quotes that express empathy and understanding.
    Submit your own contributions to share your vision of empathy.
  </p>

  <section id="gallery" aria-label="Art of Empathy Gallery">
    <!-- Static items -->
    <div class="gallery-item" tabindex="0" data-category="photo" aria-label="Empathy Photo - Two hands holding each other">
      <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=300&q=80" alt="Two hands holding each other" />
      <div class="caption">Empathy Photo</div>
      <div class="quote">"Holding hands in support"</div>
    </div>

    <div class="gallery-item" tabindex="0" data-category="painting" aria-label="Empathy Painting - Embrace in pastel colors">
      <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=300&q=80" alt="Embrace painting" />
      <div class="caption">Empathy Painting</div>
      <div class="quote">"Soft embrace in pastel colors"</div>
    </div>

    <div class="gallery-item" tabindex="0" data-category="quote" aria-label="Empathy Quote - 'Empathy is seeing with the eyes of another'">
      <div class="caption" style="font-size:1.2rem; background: none; color:#ffcc70;">Empathy Quote</div>
      <div class="quote" style="font-weight: 700; font-style: normal; color:#fff; margin-top: 0.5rem;">
        "Empathy is seeing with the eyes of another, listening with the ears of another and feeling with the heart of another." – Alfred Adler
      </div>
    </div>

    <div class="gallery-item" tabindex="0" data-category="quote" aria-label="Empathy Quote - 'The greatest gift you can give is understanding'">
      <div class="caption" style="font-size:1.2rem; background: none; color:#ffcc70;">Empathy Quote</div>
      <div class="quote" style="font-weight: 700; font-style: normal; color:#fff; margin-top: 0.5rem;">
        "The greatest gift you can give another is the gift of understanding." – Bryant H. McGill
      </div>
    </div>
  </section>

  <!-- Modal -->
  <div id="modal" role="dialog" aria-modal="true" aria-labelledby="modal-caption" tabindex="-1">
    <div id="modal-close" aria-label="Close modal" role="button" tabindex="0">&times;</div>
    <div id="modal-content">
      <img id="modal-img" src="" alt="" />
      <div id="modal-caption"></div>
    </div>
  </div>

  <!-- Submission Form -->
  <form id="submit-form" aria-label="Submit your empathy art or quote">
    <h2>Submit Your Empathy Art or Quote</h2>

    <label for="title">Title *</label>
    <input type="text" id="title" name="title" required maxlength="255" />

    <label for="category">Category *</label>
    <select id="category" name="category" required>
      <option value="" disabled selected>Select category</option>
      <option value="photo">Photo</option>
      <option value="painting">Painting</option>
      <option value="quote">Quote</option>
    </select>

    <label for="description">Description or Quote *</label>
    <textarea id="description" name="description" required maxlength="1000"></textarea>

    <label for="imageUrl">Image URL (optional, for photos or paintings)</label>
    <input type="text" id="imageUrl" name="imageUrl" placeholder="https://example.com/image.jpg" />

    <button type="submit">Submit</button>
  </form>

</main>

<script>
          const div = document.createElement('div');
        div.className = 'gallery-item';
        div.setAttribute('tabindex', '0');
        div.setAttribute('data-category', item.category);
        div.setAttribute('aria-label', `${item.category} - ${item.title}`);

        if (item.category === 'quote') {
          div.innerHTML = `
            <div class="caption" style="font-size:1.2rem; background: none; color:#ffcc70;">${item.title}</div>
            <div class="quote" style="font-weight: 700; font-style: normal; color:#fff; margin-top: 0.5rem;">
              "${item.description}"
            </div>
          `;
        } else {
          div.innerHTML = `
            <img src="${item.image_url}" alt="${item.title}" />
            <div class="caption">${item.title}</div>
            <div class="quote">${item.description}</div>
          `;

          // Enable modal for dynamic image items
          div.addEventListener('click', () => {
            modal.style.display = 'flex';
            modalImg.src = item.image_url;
            modalImg.alt = item.title;
            modalCaption.textContent = `${item.title} — ${item.description}`;
            modal.focus();
          });

          div.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              div.click();
            }
          });
        }

        gallery.appendChild(div);
      });
      // Load any existing submissions when the page loads
window.addEventListener('DOMContentLoaded', loadSubmissions);


  [
  {
    "title": "Kindness in Action",
    "category": "photo",
    "description": "A moment of shared laughter.",
    "image_url": "https://example.com/photo.jpg"
  },
  {
    "title": "Walk in Their Shoes",
    "category": "quote",
    "description": "Empathy begins with understanding life from another person’s perspective."
  }
]
  // Modal logic
  const modal = document.getElementById('modal');
  const modalImg = document.getElementById('modal-img');
  const modalCaption = document.getElementById('modal-caption');
  const modalClose = document.getElementById('modal-close');

  modalClose.addEventListener('click', () => {
    modal.style.display = 'none';
  });
  modalClose.addEventListener('keydown', (e) => {
    if(e.key === 'Enter' || e.key === ' ') {
      modal.style.display = 'none';
      e.preventDefault();
    }
  });

  window.addEventListener('click', (e) => {
    if (e.target === modal) {
      modal.style.display = 'none';
    }
  });

  // Handle opening modal on static items (photos/paintings)
  document.querySelectorAll('.gallery-item').forEach(item => {
    if (item.querySelector('img')) {
      item.addEventListener('click', () => {
        const img = item.querySelector('img');
        const title = item.querySelector('.caption').textContent;
        const desc = item.querySelector('.quote').textContent;

        modal.style.display = 'flex';
        modalImg.src = img.src;
        modalImg.alt = img.alt;
        modalCaption.textContent = `${title} — ${desc}`;
        modal.focus();
      });
      item.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
          e.preventDefault();
          item.click();
        }
      });
    }
  });

  // Submit form via AJAX
  const form = document.getElementById('submit-form');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);

    try {
      const response = await fetch('submit_art.php', {
        method: 'POST',
        body: formData,
      });

      const result = await response.json();

      if (response.ok && result.success) {
        alert('Thank you for your submission! It has been saved.');
        form.reset();
        loadSubmissions();
      } else {
        alert(result.error || 'Submission failed');
      }
    } catch (error) {
      alert('Error submitting form. Please try again later.');
    }
  });

  // Load saved submissions dynamically
  async function loadSubmissions() {
    try {
      const response = await fetch('fetch_submissions.php');
      if (!response.ok) throw new Error('Network error');
      const data = await response.json();

      const gallery = document.getElementById('gallery');

      // Number of static items to preserve
      const staticItemsCount = 4;
      // Remove old user submissions (items after static ones)
      while (gallery.children.length > staticItemsCount) {
        gallery.removeChild(gallery.lastChild);
      }

      data.forEach(item => {
        const div = document.createElement('div');
        div.className = 'gallery-item';
        div.setAttribute('data-category', item.category);
        div.setAttribute('tabindex', '0');

        if (item.imageUrl) {
          div.innerHTML = `
            <img src="${item.imageUrl}" alt="${item.title}" />
            <div class="caption">${item.title}</div>
            <div class="quote">${item.description}</div>
          `;

          div.addEventListener('click', () => {
            modal.style.display = 'flex';
            modalImg.src = item.imageUrl;
            modalImg.alt = item.title;
            modalCaption.textContent = `${item.title} — ${item.description}`;
            modal.focus();
          });
          div.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              div.click();
            }
          });
        } else {
          div.innerHTML = `
            <div class="caption" style="font-size:1.2rem; background: none; color:#ffcc70;">${item.title}</div>
            <div class="quote" style="font-weight: 700; font-style: normal; color:#fff; margin-top: 0.5rem;">${item.description}</div>
          `;
        }

        gallery.appendChild(div);
      });
    } catch (err) {
      console.error('Failed to load submissions:', err);
    }
  }

  // Load submissions on page load
  window.addEventListener('DOMContentLoaded', loadSubmissions);
</script>

</body>
</html>
