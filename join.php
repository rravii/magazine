<div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">X</button>
      <h1>Join Us</h1>
</div>
<div class="modal-body">
    <div class="panel panel-default">
        <div class="panel-heading text-center">
            Please fill up the form:
        </div>
        <form action="process/join" method="post">
            <div class="panel-body" style="padding: 0px 50px 0px 50px">
                    <div class="text-left">Name:</div>
                    <input type="text" name="name" id="name" class="form-control">
                    <div class="text-left">Email:</div>
                    <input type="text" name="email" id="email" class="form-control">
                    <div class="text-left">Skills and Experience:</div>
                    <textarea name="message" id="message" cols="30" rows="6" class="form-control"></textarea>
            </div>
            <p>* We'll mail you if you are eligible.</p>
            <div class="modal-footer">
                <div class="panel-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>