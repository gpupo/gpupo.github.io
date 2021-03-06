(function ($, undefined) {

  // Put custom repo URL's in this object, keyed by repo name.
  var repoUrls = {
  };
  // Put custom repo descriptions in this object, keyed by repo name.
  var repoDescriptions = {
  };

  function repoUrl(repo) {

      if (null === repo.homepage || 10 > repo.homepage.length) {
          return repo.html_url;
      }

      // return 'https://opensource.gpupo.com/'+repo.name;
      return repoUrls[repo.name] || repo.homepage || repo.html_url;
  }
  function repoDescription(repo) {
    return repoDescriptions[repo.name] || repo.description;
  }

  function addRecentlyUpdatedRepo(repo) {

      if (repo.name.indexOf(".io") > 0) {
          return false;
      }

    var $item = $("<li>");

    var $name = $("<a>").attr("href", repoUrl(repo)).text(repo.name);
    $item.append($("<span>").addClass("name").append($name));

    var $time = $("<a>").attr("href", repoUrl(repo) + "/commits").text(strftime("%h %e, %Y", repo.pushed_at));
    $item.append($("<span>").addClass("time").append($time));

    $item.append('<span class="bullet">&sdot;</span>');

    var $watchers = $("<a>").attr("href", repoUrl(repo) + "/watchers").text(repo.watchers + " watchers");
    $item.append($("<span>").addClass("watchers").append($watchers));

    $item.append('<span class="bullet">&sdot;</span>');

    var $forks = $("<a>").attr("href", repoUrl(repo) + "/network").text(repo.forks + " forks");
    $item.append($("<span>").addClass("forks").append($forks));

    $item.appendTo("#recently-updated-repos");
  }


  function addControllVersionInfo(repo)
  {
        // $("<p>").text("git clone --depth=1 "+repo.ssh_url+";").appendTo("#clone");

        var $versionP = $("<tr>").addClass(repo.name);
        var $label = $("<td>").addClass("label").html(repo.name).appendTo($versionP);
        var $version = $("<td>").addClass("v").appendTo($versionP);
        $versionP.appendTo("#versions");

        $.get(repo.tags_url).done(function (data) {
          $('#versions .'+repo.name+" .v").html(data[0].name);
        });

        // $("<p>").text("ln -snf ~/workspace/gpupo/"+repo.name+" ./").appendTo("#linkAll");
  }

  function addRepo(repo) {

    if (repo.name.indexOf(".io") > 0) {
        return false;
    }



    var $item = $("<li>").addClass("repo grid-1 " + (repo.language || '').toLowerCase());
    var $itemDiv = $("<div>").addClass("item").appendTo($item);

    var $link = $("<a>").attr("href", repoUrl(repo)).appendTo($itemDiv);
    $link.append($("<h2>").text(repo.name));
    $itemDiv.append($("<h3>").text(repo.watchers + " watchers" + " / " + repo.forks + " forks"));
    $itemDiv.append($("<p>").text(repoDescription(repo)));


    //$itemDiv.append($("<p>").text("Updated "+strftime("%h %e, %Y", repo.pushed_at)));

    $itemDiv.append($("<h3>").addClass("language").text(repo.language));
    repo.description = ""+repo.description
    var $badge = $("<p>").addClass("badges").appendTo($itemDiv);
    if(repo.description.indexOf('[outdated]') !== -1 || repo.archived === true){
        //$badge.append($("<div>").addClass("outdated"));
        $badge.append($("<img>").attr('src', 'images/dead-icon.png'));
    } else if ('PHP' === repo.language){
        addControllVersionInfo(repo);
        $badge.append($("<img>").attr('src', 'https://poser.pugx.org/gpupo/'+repo.name+'/v/stable'));
        $badge.append($("<img>").attr('src', 'https://poser.pugx.org/gpupo/'+repo.name+'/downloads'));
        $badge.append($("<img>").attr('src', 'https://secure.travis-ci.org/gpupo/'+repo.name+'.png?branch=master'));
        $badge.append($("<img>").attr('src', 'https://github.com/gpupo/'+repo.name+'/workflows/CI/badge.svg'));
        // $badge.append($("<img>").attr('src', 'https://scrutinizer-ci.com/g/gpupo/'+repo.name+'/badges/quality-score.png?b=master'));
        // $badge.append($("<img>").attr('src', 'https://codeclimate.com/github/gpupo/'+repo.name+'/badges/gpa.svg'));
    } else {
       addControllVersionInfo(repo);
    }

    var pushat = "" +repo.pushed_at;
    $itemDiv.append($("<p>").addClass("timestamp").text("Updated "+ pushat.substr(3,12)));

    $item.appendTo("#repos");
  }

  $.getJSON("https://api.github.com/users/gpupo/repos?per_page=100&callback=?", function (result) {
    var repos = result.data;

    $(function () {
      $("#num-repos").text(repos.length);
      // Convert pushed_at to Date.
      $.each(repos, function (i, repo) {
        //console.log(repo);
        if (true === repo.fork) {
            return;
        }
        repo.pushed_at = new Date(repo.pushed_at);
        var weekHalfLife  = 1.146 * Math.pow(10, -9);
        var pushDelta    = (new Date) - Date.parse(repo.pushed_at);
        var createdDelta = (new Date) - Date.parse(repo.created_at);
        var weightForPush = 1;
        var weightForWatchers = 1.314 * Math.pow(10, 7);

        repo.hotness = weightForPush * Math.pow(Math.E, -1 * weekHalfLife * pushDelta);
        repo.hotness += weightForWatchers * repo.watchers / createdDelta;
      });

      // Sort by highest # of watchers.
      repos.sort(function (a, b) {
        if (a.hotness < b.hotness) return 1;
        if (b.hotness < a.hotness) return -1;
        return 0;
      });

      $.each(repos, function (i, repo) {
        addRepo(repo);
      });

      // Sort by most-recently pushed to.
      repos.sort(function (a, b) {
        if (a.pushed_at < b.pushed_at) return 1;
        if (b.pushed_at < a.pushed_at) return -1;
        return 0;
      });

      $.each(repos.slice(0, 4), function (i, repo) {
        addRecentlyUpdatedRepo(repo);
      });
    });
  });

})(jQuery);
