<form method="post" action="post.php?postID=<?=$postID ?>">
<div class="row">
    Commenting as:
</div>
<div class="row form-element">
    <?php
        $userquery2 = "SELECT userLogin FROM project_blog_users WHERE userID = ".$_SESSION['user']['userID'];
        $stmt3 = $db->prepare($userquery2); // Returns a PDOStatement object.
        $stmt3->execute(); // The query is now executed.
        $userdisplayname = $stmt3->fetch();
    ?>
    <h6><?= $userdisplayname['userLogin'] ?></h6>
</div>
<div class="row">
    <label for="commentContent"><h3>Comment: </h3></label>
</div>
<div class="row form-element">
    <textarea class="form-element" id="commentContent" name="commentContent" row="100" cols="200"></textarea>
</div>

<input type="hidden" id="commentAuthor" name="commentAuthor" value="<?= $_SESSION['user']['userID'] ?>">
<input type="hidden" id="postID" name="postID">
<input type="hidden" id="commentDate" name="commentDate">

<div class="row form-element">
    <input type="submit" value="Comment">
</div>
</form>