<h1>Fastest Cars Based on Acceleration from 0-60MPH</h1>
<div><img style="max-width:800px; width: 100%;" src="/images/<?= ($item['photo']) ?>"></div>
<h2><?= ($item['name']) ?> <?php if ($is_admin): ?><a href="/edit/<?= ($item['id']) ?>">Edit</a><?php endif; ?></h2>

<table style= "background-color: rgb(0, 0, 0);" border="5" align="center">
    <tr>
        <th>Brand and Model:</th><td><?= ($item['name']) ?></td>
    </tr>
    <tr>
        <th>Horse Power:</th><td><?= ($item['horsepower']) ?></td>
    </tr>
    <tr>
        <th>Price:</th><td><?= ($item['price']) ?></td>
    </tr>
    <tr>
        <th>0-60MPH Time:</th><td><?= ($item['time']) ?></td>
    </tr>
    <tr>
        <th>Year:</th><td><?= ($item['year']) ?></td>
    </tr>
</table>
    <h3><?= ($item['description']) ?></h3>

<?php if ($previousItem): ?>
    <a href="/detail/<?= ($previousItem[0]['id']) ?>">Previous</a>
<?php endif; ?>
<?php if ($nextItem): ?>
    <a href="/detail/<?= ($nextItem[0]['id']) ?>">Next</a>
<?php endif; ?>


<hr>
<h4>Comments</h4>

<div id="commentApp" class="card mb-3">
    <div class="m-3" v-if="!comments || comments.length == 0">No comments yet for this page.</div>
    <div class="card-body" v-for="({ email, date, body }, index) in comments" :style="calcBorder(index)">
        <div class="d-flex flex-start align-items-center">
            <div>
                <h6 class="fw-bold text-secondary mb-1">{{ email }}</h6>
                <p class="text-muted small mb-0">
                    {{ date }}
                </p>
            </div>
        </div>
        <p class="mt-3 mb-4">
            {{ body }}
        </p>
    </div>
    <div class="card-footer py-3 border-0" style="background-color: #4e4140;">
        <div v-if="userId" class="form-floating">
            <textarea v-model="newComment" class="form-control" style="height: 6em" placeholder="Leave a comment here" name="comments"></textarea>
            <label for="commentInput">Comments</label>
        </div>
        <div v-if="userId" class="float-end mt-2 pt-1">
            <button @click="saveComment" type="button" class="btn btn-primary btn-sm">Post comment</button>
        </div>
        <p v-else>Please log in to comment.</p>
    </div>
</div>


<script>
    const { createApp } = Vue

    createApp({
        data: () => ({
            comments: null,
            itemId: '<?= ($item['id']) ?>',
           userId: '<?= ($current_user_map['id']) ?>',
            email: '<?= ($current_user_map['email']) ?>',
            newComment: ''
        }),

        created() {
            // fetch on init
            this.fetchData()
        },

        methods: {
            async fetchData() {
                const url = '/api/car/' + this.itemId + '/comments';
                const response = await fetch(url);
                this.comments = await response.json();
            },
            calcBorder(index) {
                style = {};
                if (index < this.comments.length-1) {
                    style.borderBottom = '1px solid #EEE';
                }
                return style;
            },
            async saveComment() {
                const url = '/api/comments';                var d = new Date();
                const data = {
                    body: this.newComment,
                   user_id: this.userId,
                    context_id: this.itemId,
                    // "cool" date one-liner (who needs timezones?)
                    date: d.toISOString().split('T')[0]+' '+d.toTimeString().split(' ')[0]
                };
                const opt = {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(data)
                }
                const response = await fetch(url, opt);
                const responseData = await response.json();
                responseData['email'] = this.email;
                if (Array.isArray(this.comments)) {
                    this.comments.push(responseData);
                } else {
                    this.comments = [responseData];
                }
                this.newComment = '';
            }
        }
    }).mount('#commentApp')
</script>
</hr>
</p>
</div>
