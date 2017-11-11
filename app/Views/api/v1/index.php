<br>
<div class="row">
    <div id="api" class="col-sm-12 col-lg-10 col-lg-offset-1">
        <dl>
            <dt>
                <p>Preparing to interact with the API</p>
            </dt>
            <dd>
                <p>
                    In order to interact with the API, you must have a pre-qualified access key and token. Your
                    key and token are necessary to interact with the api and are required with every request made.
                </p>
            </dd>
            <dt>
                <p>Using your 'key' and 'token'</p>
            </dt>
            <dd>
                <p>
                    Every request needs to include it's key and token within the request string.<br>
                    <strong>Example:</strong>
                    <code>http://spring_notes/v1/entrypoint?key=your_key&amp;token=your_token</code>
                </p>
            </dd>
            <dt>
                <p>Response Body</p>
            </dt>
            <dd>
                <p>All responses will conform to this schema</p>
                <pre class="prettyprint json"><code>
{
    "results": "mixed",
    "error": "array"
}
                    </code></pre>
            </dd>
        </dl>
        <br>
        <p class="h2 text-center"><strong>Notes API</strong></p>
        <br>
        <dl>
            <dt>
                <p class="lead">Getting all notes</p>
            </dt>
            <dd>
                <p>
                    <strong>Request:</strong> <code>GET - /v1/notes HTTP/1.1</code>
                </p>
                <p>
                    <strong>Example:</strong> <code>/v1/notes?:tokens</code>
                </p>
                <p><strong>Response:</strong> Returns an array of all notes</p>
                <pre class="prettyprint json"><code>
{
    "results": [
        {
            "id": 1,
            "name": "test",
            "title": "A Simple Sample",
            "body": "Here is a sample note",
            "created_at": "2017-11-08 22:50:06",
            "updated_at": null
        },
        {
            "id": 2,
            "name": "test",
            "title": "Another Simple Sample",
            "body": "Here is another simple sample.\r\n\r\nThis is a modified note.",
            "created_at": "2017-11-08 22:50:54",
            "updated_at": "2017-11-08 22:51:12"
        }
    ],
    "error": []
}
                </code></pre>
            </dd>
            <dt>
                <p class="lead">Getting a note by id</p>
            </dt>
            <dd>
                <p>
                    <strong>Request:</strong><code>GET - /v1/notes/{id} HTTP/1.1</code>
                </p>
                <p>
                    <strong>Example:</strong> <code>/v1/notes/2?:tokens</code>
                </p>
                <p><strong>Response:</strong> Returns a single note</p>
                <pre class="prettyprint json"><code>
{
    "results": {
        "id": 2,
        "name": "test",
        "title": "Another Simple Sample",
        "body": "Here is another simple sample.\r\n\r\nThis is a modified note.",
        "created_at": "2017-11-08 22:50:54",
        "updated_at": "2017-11-08 22:51:12"
    },
    "error": []
}
                </code></pre>
            </dd>
            <dt>
                <p class="lead">Getting all notes for a user</p>
            </dt>
            <dd>
                <p>
                    <strong>Request:</strong><code>GET - /v1/notes/{id}/user_id HTTP/1.1</code>
                </p>
                <p>
                    <strong>Example:</strong> <code>/v1/notes/1/user_id?:tokens</code>
                </p>
                <p><strong>Response:</strong> Returns an array of notes for that user</p>
                <pre class="prettyprint json"><code>
{
    "results": [
        {
            "id": 1,
            "name": "test",
            "title": "A Simple Sample",
            "body": "Here is a sample note",
            "created_at": "2017-11-08 22:50:06",
            "updated_at": null
        },
        {
            "id": 2,
            "name": "test",
            "title": "Another Simple Sample",
            "body": "Here is another simple sample.\r\n\r\nThis is a modified note.",
            "created_at": "2017-11-08 22:50:54",
            "updated_at": "2017-11-08 22:51:12"
        }
    ],
    "error": []
}
                    </code></pre>
            </dd>
            <dt>
                <p class="lead">Create a new note</p>
            </dt>
            <dd>
                <p>
                    <strong>Request:</strong><code>POST - /v1/notes HTTP/1.1</code>
                </p>
                <p>
                    <strong>Request body schema:</strong>
                </p>
                <pre class="prettyprint json"><code>
{
	"user_id":"int|required",
	"title":"string|required",
	"body":"string|required"
}
                    </code></pre>
                <p>
                    <strong>Example:</strong> <code>/v1/notes?:tokens</code>
                </p>
                <pre class="prettyprint json"><code>
{
	"user_id":1,
	"title":"this is a fun app",
	"body":"I enjoy making notes"
}
                    </code></pre>
                <p><strong>Response:</strong> Returns the id of the note created</p>
                <pre class="prettyprint json"><code>
{
    "results": 15,
    "error": []
}
                    </code></pre>
            </dd>
            <dt>
                <p class="lead">Update a note</p>
            </dt>
            <dd>
                <p>
                    <strong>Request:</strong><code>GET - /v1/notes/{id}/user_id HTTP/1.1</code>
                </p>
                <p>
                    <strong>Request body schema:</strong>
                </p>
                <pre class="prettyprint json"><code>
{
	"user_id":"int|required",
	"title":"string|optional",
	"body":"string|optional"
}
                    </code></pre>
                <p>
                    <strong>Example:</strong> <code>/v1/notes/15?:tokens</code>
                </p>
                <pre class="prettyprint json"><code>
{
    "id":15,
    "body":"I enjoy updating notes"
}
                    </code></pre>
                <p><strong>Response:</strong> Returns a boolean value indicating note was updated</p>
                <pre class="prettyprint json"><code>
{
    "results": true,
    "error": []
}
                    </code></pre>
            </dd>
            <dt>
                <p class="lead">Delete a note</p>
            </dt>
            <dd>
                <p>
                    <strong>Request:</strong><code>DELETE - /v1/notes/{id} HTTP/1.1</code>
                </p>
                <p>
                    <strong>Example:</strong> <code>/v1/notes/15?:tokens</code>
                </p>
                <p><strong>Response:</strong> Returns a boolean value indicating note was deleted</p>
                <pre class="prettyprint json"><code>
{
    "results": true,
    "error": []
}
                    </code></pre>
            </dd>
        </dl>
    </div>
</div>

<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js?skin=desert"></script>
<script>
	$(document).ready(function () {
		PR.prettyPrint();
	});
</script>
