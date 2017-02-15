function clearSlate() {
    if (working) {
        speech.stop();
    }
    document.getElementById("labnol").innerHTML = "";
    document.getElementById("notfinal").innerHTML = "";
    final_transcript = "";
    reset();
}

function reset() {
    working = false;
    document.getElementById("status").style.display = "none";
    document.getElementById("btn").innerHTML = "Start";
}

function action() {
    if (working) {
        speech.stop();
        reset();
    } else {
        speech.start();
        working = true;
        document.getElementById("status").style.display = "block";
        document.getElementById("btn").innerHTML = "Stop ";
    }
}

function toggleVisibility(selectedTab) {
    var content = document.getElementsByClassName('info');
    for (var i = 0; i < content.length; i++) {
        if (content[i].id == selectedTab) {
            content[i].style.display = 'block';
        } else {
            content[i].style.display = 'none';
        }
    }
}
 

function updateLang(sel) {
    var value = sel.options[sel.selectedIndex].value;
    speech.lang = getLang(value);
    localStorage["language"] = value;
}

function format(s) {
    return s.replace(/\n/g, '<br>');
}

function capitalize(s) {
    return s.replace(/\S/, function(m) {
        return m.toUpperCase();
    });
}

function initialize() {
    speech = new webkitSpeechRecognition();
    speech.continuous = true;
    speech.maxAlternatives = 5;
    speech.interimResults = true;
    speech.lang = getLang(localStorage["language"]);
    speech.onend = reset;
}

var clear, working, speech, final_transcript = "";

if (typeof(webkitSpeechRecognition) !== 'function') {

    document.getElementById("labnol").innerHTML = "We are sorry but Dictation requires the latest version of Google Chrome on your desktop.";
    document.getElementById("messages").style.display = "none";

} else {

    if (typeof(localStorage["language"]) == 'undefined') {
        localStorage["language"] = 12;
    }

    if (typeof(localStorage["transcript"]) == 'undefined') {
        localStorage["transcript"] = "";
    }

    document.getElementById("labnol").innerHTML = localStorage["transcript"];
    final_transcript = localStorage["transcript"];

    setInterval(function() {
        var text = document.getElementById("labnol").innerHTML;
        if (text !== localStorage["transcript"]) {
            localStorage["transcript"] = text;
        }
    }, 2000);

    document.getElementById("lang").value = localStorage["language"];

    initialize();
    reset();

    speech.onerror = function(e) {
        var msg = e.error + " error";
        if (e.error === 'no-speech') {
            msg = "No speech was detected. Please try again.";
        } else if (e.error === 'audio-capture') {
            msg = "Please ensure that a microphone is connected to your computer.";
        } else if (e.error === 'not-allowed') {
            msg = "The app cannot access your microphone. Please go to chrome://settings/contentExceptions#media-stream and allow Microphone access to this website.";
        }
        document.getElementById("warning").innerHTML = "<p>" + msg + "</p>";
        setTimeout(function() {
            document.getElementById("warning").innerHTML = "";
        }, 5000);
    };

    speech.onresult = function(e) {
        var interim_transcript = '';
        if (typeof(e.results) == 'undefined') {
            reset();
            return;
        }
        for (var i = e.resultIndex; i < e.results.length; ++i) {
            var val = e.results[i][0].transcript;
            if (e.results[i].isFinal) {
                final_transcript += " " + val;
            } else {
                interim_transcript += " " + val;
            }
        }
        document.getElementById("labnol").innerHTML = format(capitalize(final_transcript));
        document.getElementById("notfinal").innerHTML = format(interim_transcript);
    };
}

function getLang(opt) {
    var langs = [
        ["Afrikaans", "af-za", "--", "en-us"],
        ["Bahasa Indonesia", "id-id", "--", "id-id"],
        ["Bahasa Melayu", "ms-my", "--", "ms-my"],
        ["Català", "ca-es", "--", "ca-es"],
        ["Čeština", "cs-cz", "--", "cs-cz"],
        ["Deutsch", "de-de", "--", "de-de"],
        ["Australia", "en-au", "English", "en-gb"],
        ["Canada", "en-ca", "English", "en-us"],
        ["India", "en-in", "English", "en-gb"],
        ["New Zealand", "en-nz", "English", "en-gb"],
        ["South Africa", "en-za", "English", "en-gb"],
        ["United Kingdom", "en-gb", "English", "en-gb"],
        ["United States", "en-us", "English", "en-us"],
        ["Argentina", "es-ar", "Español", "es-419"],
        ["Bolivia", "es-bo", "Español", "es-419"],
        ["Chile", "es-cl", "Español", "es-419"],
        ["Colombia", "es-co", "Español", "es-419"],
        ["Costa Rica", "es-cr", "Español", "es-419"],
        ["Ecuador", "es-ec", "Español", "es-419"],
        ["El Salvador", "es-sv", "Español", "es-419"],
        ["España", "es-es", "Español", "es"],
        ["Estados Unidos", "es-us", "Español", "es-419"],
        ["Guatemala", "es-gt", "Español", "es-419"],
        ["Honduras", "es-hn", "Español", "es-419"],
        ["México", "es-mx", "Español", "es-419"],
        ["Nicaragua", "es-ni", "Español", "es-419"],
        ["Panamá", "es-pa", "Español", "es-419"],
        ["Paraguay", "es-py", "Español", "es-419"],
        ["Perú", "es-pe", "Español", "es-419"],
        ["Puerto Rico", "es-pr", "Español", "es-419"],
        ["Rep. Dominicana", "es-do", "Español", "es-419"],
        ["Uruguay", "es-uy", "Español", "es-419"],
        ["Venezuela", "es-ve", "Español", "es-419"],
        ["Euskara", "eu-es", "--", "en-us"],
        ["Français", "fr-fr", "--", "fr"],
        ["Galego", "gl-es", "--", "en-us"],
        ["IsiZulu", "zu-za", "--", "en-us"],
        ["Íslenska", "is-is", "--", "en-us"],
        ["Italiano Italia", "it-it", "Italiano", "it"],
        ["Italiano Svizzera", "it-ch", "Italiano", "it"],
        ["Magyar", "hu-hu", "--", "hu"],
        ["Nederlands", "nl-nl", "--", "nl"],
        ["Polski", "pl-pl", "--", "pl"],
        ["Brasil", "pt-br", "Português", "pt-br"],
        ["Portugal", "pt-pt", "Português", "pt-pt"],
        ["Română", "ro-ro", "--", "ro"],
        ["Slovenčina", "sk-sk", "--", "sk"],
        ["Suomi", "fi-fi", "--", "fi"],
        ["Svenska", "sv-se", "--", "sv"],
        ["Türkçe", "tr-tr", "--", "tr"],
        ["български", "bg-bg", "--", "bg"],
        ["Pусский", "ru-ru", "--", "ru"],
        ["Српски", "sr-rs", "--", "sr"],
        ["한국어", "ko-kr", "--", "ko"],
        ["普通话 (中国大陆)", "cmn-hans-cn", "中文", "zh-cn"],
        ["普通话 (香港)", "cmn-hans-hk", "中文", "zh-cn"],
        ["中文 (台灣)", "cmn-hant-tw", "中文", "zh-tw"],
        ["粵語 (香港)", "yue-hant-hk", "中文", "zh-cn"],
        ["日本語", "ja-jp", "--", "ja"],
        ["Lingua latīna", "la", "--", "es-419"]
    ];
    return langs[opt][1];
}

 