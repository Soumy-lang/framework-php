<h2>Mes pages</h2>

<div class="post-page">
    <!-- <section class="section1-status-tab">
        <table class="status-tab">
            <thead>
                <tr class="tab">
                    <th class="tab-item active"><a href="#">Tous</a></th>
                    <th class="tab-item"><a href="#">Brouillon</a></th>
                </tr>
            </thead>
        </table>
    </section> -->
    <!-- <section class="section2-search-bar">
        <div class="block-line-search">
            <label for="input-name"></label>
            <input type="text" id="input-name" class="search-input" placeholder="Rechercher..."/>
        </div>
    </section> -->
    <section class="section3-information-page">
        <table class="status-tab">
            <thead>
            <tr class="tab">
                <th class="tab-item active">Titre</th>
                <th class="tab-item">Date</th>
                <th class="tab-item">Status</th>
                <th class="tab-item">Voir</th>
            </tr>
            </thead>
            <?php
            if (isset($this->data['posts'])) {
                foreach ($this->data['posts'] as $post) {
                    $postId = $post->getId();
                    $title = $post->getTitle();
                    $createdAt = (new DateTime($post->getCreatedat()))->format('Y-m-d');
                    $status = $post->getPublished() ? 'Publié' : "Non publié";
                    echo "
                    <tr class='tab-page'>
                        <td>$title</td>
                        <td>$createdAt</td>
                        <td>$status</td>
                        <td>
                            <a href='/bo/pages/edit-page?page=$postId' class='link-primary'><i class='fa fa-eye' aria-hidden='true'></i></a>
                        </td>
                    </tr>
                    ";
                }
            }
            ?>
        </table>
    </section>
    <section class="section4-add">
        <a href="/bo/pages/add-page" class="add-content">
            <button class="button button-primary">Ajouter</button>
        </a>
    </section>
</div>
