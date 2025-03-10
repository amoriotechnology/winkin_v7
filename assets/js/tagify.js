var u = document.querySelector("input[name=basic]");
new Tagify(u);
var r = document.querySelector("input[name=tags4]"),
    a = new Tagify(r),
    r = document.querySelector("input[name=tags-readonly-mix]"),
    a = new Tagify(r),
    p = document.querySelector('input[name="input-custom-dropdown"]'),
    a = new Tagify(p, {
        whitelist: ["A# .NET", "A# (Axiom)", "A-0 System", "A+", "A++", "ABAP", "ABC", "ABC ALGOL", "ABSET", "ABSYS", "ACC", "Accent", "Ace DASL", "ACL2", "Avicsoft", "ACT-III", "Action!", "ActionScript", "Ada", "Adenine", "Agda", "Agilent VEE", "Agora", "AIMMS", "Alef", "ALF", "ALGOL 58", "ALGOL 60", "ALGOL 68", "ALGOL W", "Alice", "Alma-0", "AmbientTalk", "Amiga E", "AMOS", "AMPL", "Apex (Salesforce.com)", "APL", "AppleScript", "Arc", "ARexx", "Argus", "AspectJ", "Assembly language", "ATS", "Ateji PX", "AutoHotkey", "Autocoder", "AutoIt", "AutoLISP / Visual LISP", "Averest", "AWK", "Axum", "Active Server Pages", "ASP.NET", "B", "Babbage", "Bash", "BASIC", "bc", "BCPL", "BeanShell", "Batch (Windows/Dos)", "Bertrand", "BETA", "Bigwig", "Bistro", "BitC", "BLISS", "Blockly", "BlooP", "Blue", "Boo", "Boomerang", "Bourne shell (including bash and ksh)", "BREW", "BPEL", "B", "C--", "C++ – ISO/IEC 14882", "C# – ISO/IEC 23270", "C/AL", "Caché ObjectScript", "C Shell", "Caml", "Cayenne", "CDuce", "Cecil", "Cesil", "Céu", "Ceylon", "CFEngine", "CFML", "Cg", "Ch", "Chapel", "Charity", "Charm", "Chef", "CHILL", "CHIP-8", "chomski", "ChucK", "CICS", "Cilk", "Citrine (programming language)", "CL (IBM)", "Claire", "Clarion", "Clean", "Clipper", "CLIPS", "CLIST", "Clojure", "CLU", "CMS-2", "COBOL – ISO/IEC 1989", "CobolScript – COBOL Scripting language", "Cobra", "CODE", "CoffeeScript", "ColdFusion", "COMAL", "Combined Programming Language (CPL)", "COMIT", "Common Intermediate Language (CIL)", "Common Lisp (also known as CL)", "COMPASS", "Component Pascal", "Constraint Handling Rules (CHR)", "COMTRAN", "Converge", "Cool", "Coq", "Coral 66", "Corn", "CorVision", "COWSEL", "CPL", "CPL", "Cryptol", "csh", "Csound", "CSP", "CUDA", "Curl", "Curry", "Cybil", "Cyclone", "Cython", "Java", "Javascript", "M2001", "M4", "M#", "Machine code", "MAD (Michigan Algorithm Decoder)", "MAD/I", "Magik", "Magma", "make", "Maple", "MAPPER now part of BIS", "MARK-IV now VISION:BUILDER", "Mary", "MASM Microsoft Assembly x86", "MATH-MATIC", "Mathematica", "MATLAB", "Maxima (see also Macsyma)", "Max (Max Msp – Graphical Programming Environment)", "Maya (MEL)", "MDL", "Mercury", "Mesa", "Metafont", "Microcode", "MicroScript", "MIIS", "Milk (programming language)", "MIMIC", "Mirah", "Miranda", "MIVA Script", "ML", "Model 204", "Modelica", "Modula", "Modula-2", "Modula-3", "Mohol", "MOO", "Mortran", "Mouse", "MPD", "Mathcad", "MSIL – deprecated name for CIL", "MSL", "MUMPS", "Mystic Programming L"],
        maxTags: 10,
        dropdown: {
            maxItems: 20,
            classname: "tags-look",
            enabled: 0,
            closeOnSelect: !1
        }
    }),
    g = document.querySelector("input[name=tags-disabled-user-input]");
new Tagify(g, {
    whitelist: [1, 2, 3, 4, 5],
    userInput: !1
});
var r = document.querySelector("input[name=drag-sort]"),
    a = new Tagify(r);
new DragSort(a.DOM.scope, {
    selector: "." + a.settings.classNames.tag,
    callbacks: {
        dragEnd: v
    }
});

function v(e) {
    a.updateValueByDOMTags()
}
var r = document.querySelector("input[name=tags-select-mode]"),
    a = new Tagify(r, {
        enforceWhitelist: !0,
        mode: "select",
        whitelist: ["first option", "second option", "third option"],
        blacklist: ["foo", "bar"]
    });
a.on("add", A);
a.DOM.input.addEventListener("focus", C);

function A(e) {
    console.log(e.detail)
}

function C(e) {
    console.log(e)
}
var c = [{
        value: 100,
        text: "kenny",
        title: "Kenny McCormick"
    }, {
        value: 200,
        text: "cartman",
        title: "Eric Cartman"
    }, {
        value: 300,
        text: "kyle",
        title: "Kyle Broflovski"
    }, {
        value: 400,
        text: "token",
        title: "Token Black"
    }, {
        value: 500,
        text: "jimmy",
        title: "Jimmy Valmer"
    }, {
        value: 600,
        text: "butters",
        title: "Butters Stotch"
    }, {
        value: 700,
        text: "stan",
        title: "Stan Marsh"
    }, {
        value: 800,
        text: "randy",
        title: "Randy Marsh"
    }, {
        value: 900,
        text: "Mr. Garrison",
        title: "POTUS"
    }, {
        value: 1e3,
        text: "Mr. Mackey",
        title: "M'Kay"
    }],
    d = ["Homer simpson", "Marge simpson", "Bart", "Lisa", "Maggie", "Mr. Burns", "Ned", "Milhouse", "Moe"],
    r = document.querySelector("[name=mix]"),
    a = new Tagify(r, {
        mode: "mix",
        pattern: /@|#/,
        tagTextProp: "text",
        whitelist: c.concat(d).map(function(e) {
            return typeof e == "string" ? {
                value: e
            } : e
        }),
        validate(e) {
            return !/[^a-zA-Z0-9 ]/.test(e.value)
        },
        dropdown: {
            enabled: 1,
            position: "text",
            mapValueTo: "text",
            highlightFirst: !0
        },
        callbacks: {
            add: console.log,
            remove: console.log
        }
    });
a.on("input", function(e) {
    var t = e.detail.prefix;
    t && (t == "@" && (a.whitelist = c), t == "#" && (a.whitelist = d), e.detail.value.length > 1 && a.dropdown.show(e.detail.value)), console.log(a.value), console.log('mix-mode "input" event value: ', e.detail)
});
a.on("add", function(e) {
    console.log(e)
});
var M = document.querySelector("input[name=users-list-tags]");

function y(e) {
    return `
        <tag title="${e.email}"
                contenteditable='false'
                spellcheck='false'
                tabIndex="-1"
                class="tagify__tag ${e.class?e.class:""}"
                ${this.getAttributes(e)}>
            <x title='' class='tagify__tag__removeBtn' role='button' aria-label='remove tag'></x>
            <div>
                <div class='tagify__tag__avatar-wrap'>
                    <img onerror="this.style.visibility='hidden'" src="${e.avatar}">
                </div>
                <span class='tagify__tag-text'>${e.name}</span>
            </div>
        </tag>
    `
}

function f(e) {
    return `
        <div ${this.getAttributes(e)}
            class='tagify__dropdown__item ${e.class?e.class:""}'
            tabindex="0"
            role="option">
            ${e.avatar?`
                <div class='tagify__dropdown__item__avatar-wrap'>
                    <img onerror="this.style.visibility='hidden'" src="${e.avatar}">
                </div>`:""}
            <strong>${e.name}</strong>
            <span>${e.email}</span>
        </div>
    `
}

function h(e) {
    return `
        <header data-selector='tagify-suggestions-header' class="${this.settings.classNames.dropdownItem} ${this.settings.classNames.dropdownItem}__addAll">
            <strong style='grid-area: add'>${this.value.length?"Add Remaning":"Add All"}</strong>
            <span style='grid-area: remaning'>${e.length} members</span>
            <a class='remove-all-tags'>Remove all</a>
        </header>
    `
}
var a = new Tagify(M, {
    tagTextProp: "name",
    skipInvalid: !0,
    dropdown: {
        closeOnSelect: !1,
        enabled: 0,
        classname: "users-list",
        searchKeys: ["name", "email"]
    },
    templates: {
        tag: y,
        dropdownItem: f,
        dropdownHeader: h
    },
    whitelist: [{
        value: 1,
        name: "Justinian Hattersley",
        avatar: "https://i.pravatar.cc/80?img=1",
        email: "jhattersley0@ucsd.edu",
        team: "A"
    }, {
        value: 2,
        name: "Antons Esson",
        avatar: "https://i.pravatar.cc/80?img=2",
        email: "aesson1@ning.com",
        team: "B"
    }, {
        value: 3,
        name: "Ardeen Batisse",
        avatar: "https://i.pravatar.cc/80?img=3",
        email: "abatisse2@nih.gov",
        team: "A"
    }, {
        value: 4,
        name: "Graeme Yellowley",
        avatar: "https://i.pravatar.cc/80?img=4",
        email: "gyellowley3@behance.net",
        team: "C"
    }, {
        value: 5,
        name: "Dido Wilford",
        avatar: "https://i.pravatar.cc/80?img=5",
        email: "dwilford4@jugem.jp",
        team: "A"
    }, {
        value: 6,
        name: "Celesta Orwin",
        avatar: "https://i.pravatar.cc/80?img=6",
        email: "corwin5@meetup.com",
        team: "C"
    }, {
        value: 7,
        name: "Sally Main",
        avatar: "https://i.pravatar.cc/80?img=7",
        email: "smain6@techcrunch.com",
        team: "A"
    }, {
        value: 8,
        name: "Grethel Haysman",
        avatar: "https://i.pravatar.cc/80?img=8",
        email: "ghaysman7@mashable.com",
        team: "B"
    }, {
        value: 9,
        name: "Marvin Mandrake",
        avatar: "https://i.pravatar.cc/80?img=9",
        email: "mmandrake8@sourceforge.net",
        team: "B"
    }, {
        value: 10,
        name: "Corrie Tidey",
        avatar: "https://i.pravatar.cc/80?img=10",
        email: "ctidey9@youtube.com",
        team: "A"
    }, {
        value: 11,
        name: "foo",
        avatar: "https://i.pravatar.cc/80?img=11",
        email: "foo@bar.com",
        team: "B"
    }, {
        value: 12,
        name: "foo",
        avatar: "https://i.pravatar.cc/80?img=12",
        email: "foo.aaa@foo.com",
        team: "A"
    }],
    transformTag: (e, t) => {
        var {
            name: l,
            email: n
        } = m(e.name);
        e.name = l, e.email = n || e.email
    },
    validate({
        name: e,
        email: t
    }) {
        if (!t && e) {
            var l = m(e);
            e = l.name, t = l.email
        }
        return e ? w(t) ? !0 : "Invalid email" : "Missing name"
    }
});
a.dropdown.createListHTML = e => {
    const t = e.reduce((n, i) => {
            const o = i.team || "Not Assigned";
            return n[o] ? n[o].push(i) : n[o] = [i], n
        }, {}),
        l = n => n.map((i, o) => {
            (typeof i == "string" || typeof i == "number") && (i = {
                value: i
            });
            var s = a.dropdown.getMappedValue.call(a, i);
            return i.value = s && typeof s == "string" ? escapeHTML(s) : s, a.settings.templates.dropdownItem.apply(a, [i])
        }).join("");
    return Object.entries(t).map(([n, i]) => `<div class="tagify__dropdown__itemsGroup" data-title="Team ${n}:">${l(i)}</div>`).join("")
};
a.on("dropdown:select", S).on("edit:start", L);

function S(e) {
    e.detail.event.target.matches(".remove-all-tags") ? a.removeAllTags() : e.detail.elm.classList.contains(`${a.settings.classNames.dropdownItem}__addAll`) && a.dropdown.selectAll()
}

function L({
    detail: {
        tag: e,
        data: t
    }
}) {
    a.setTagTextNode(e, `${t.name} <${t.email}>`)
}

function w(e) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e)
}

function m(e) {
    var i;
    var t = e.split(/<(.*?)>/g),
        l = t[0].trim(),
        n = (i = t[1]) == null ? void 0 : i.replace(/<(.*?)>/g, "").trim();
    return {
        name: l,
        email: n
    }
}