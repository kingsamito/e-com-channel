</div>
      <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->
  </div>
  </div>
  <script>
    $("#sidebarToggle, #sidebarToggleTop").on('click', function(e) {
      $("body").toggleClass("sidebar-toggled");
      $(".sidebar").toggleClass("toggled");
      if ($(".sidebar").hasClass("toggled")) {
        $('.sidebar .collapse').collapse('hide');
      };
    });
  </script>

<script>
  function autoReload() {
    $("#reloadContent").load(window.location.href + " #reloadContent>");
  }
  setInterval('autoReload()', 5000)
</script>

<script>
  var url = window.location.href;
  var in_out = "Inbox";

  if (url.includes("inbox")) {
    in_out = "Inbox";
  }
  if (url.includes("sent")) {
    in_out = "Sent";
  }
  
  document.getElementById("in/out").innerHTML = in_out;


  var links = "";
  if (url.includes("studentdashboard.php")) {
    links = '<a class="dropdown-item" href="tester.php">Academic Request</a>\
            <a class="dropdown-item" href="exeatletter.php">Exeat Request</a>\
            <a class="dropdown-item" href="medicalexeat.php">Medical Exeat</a>\
            <a class="dropdown-item" href="otherletter.php">Others</a>';
  }
  if (url.includes("academic_staffdashboard.php")) {
    links = '<a class="dropdown-item" href="sletter.php">Letter</a>';
  }
  if (url.includes("managementdashboard.php")) {
    links = '<a class="dropdown-item" href="memo.php">Memo</a>';
  }
  if (url.includes("non_academic_staffdashboard.php")) {
    links = '<a class="dropdown-item" href="sletter.php">Letter</a>';
  }

  document.getElementById("dropdown-links").innerHTML = links;
</script>

<script>
  function findnotification() {
    var urll = window.location.href;
    var user1 = document.getElementById("user1");
    var user2 = document.getElementById("user2");
    var user3 = document.getElementById("user3");

    var value1 = user1.value;
    var value2 = user2.value;
    var value3 = user3.value;


    $.ajax({
      url: 'notification.php',
      type: "POST",
      data: {
        notify: urll,
        notify1: value1,
        notify2: value2,
        notify3: value3
      },
      success: function(data) {
        $('#retrieval').html(data);
        const parent = document.getElementById("retrieval");
        const children = Array.from(parent.children);
        const ids = children.map(element => {
          return element.id;
        })
        console.log(ids);
        console.log(ids.length);
        console.log(parent);
        console.log(children);
        run(ids);
      }
    })
  }

  setInterval('findnotification()', 1000);
</script>

<script>
  function run(ids) {
    const len = ids.length;
    console.log('len ' + len)
    for (let i = 0; i < len; i++) {
      let content = document.getElementById(ids[i]);
      let first = content.firstChild;
      let second = content.childNodes[1];
      let third = content.childNodes[2];
      let last = content.lastChild;
      console.log(first, second, third, last);
      if (Notification.permission === "granted") {
        showNotification(ids[i], first, second, third, last);
      } else if (Notification.permission !== "denied") {
        Notification.requestPermission().then(permission => {
          if (permission === "granted") {
            showNotification(ids[i], first, second, third, last);
          }
        })
      }
    }
  }
</script>
<script>
  function showNotification(i, first, second, third, last) {
    var user2 = document.getElementById("user2");
    var value2 = user2.value;


    var second = second.textContent;
    var third = third.textContent;

    var title = "New message from " + first.textContent;
    var body = last.textContent;
    const notification = new Notification(
      title, {
        body: body
      },
    );


    $.ajax({
      url: 'notification.php',
      type: "POST",
      data: {
        notifyupdate: i,
        notifyupdate1: second,
        notifyupdate2: value2,
        notifyupdate3: third
      },
      success: function(data) {

        console.log("done")
      }
    })

  }
</script>
</body>

</html>