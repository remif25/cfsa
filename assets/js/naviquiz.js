/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/naviquiz.css');

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// const $ = require('jquery');


var myProp = 'children';
var path = [];
var tree = $('.naviquiz').data('tree');
var lvl = 0;
var tmpTree = $('.naviquiz').data('tree');

$(document).ready(function() {
    displayBigQuestions(tmpTree, lvl);
    $('.alert-no-more-element').addClass('hide');
});

$(document).on('click', '.big-card-question',  function() {
    $('.alert-no-more-element').removeClass('show');
    $('.alert-no-more-element').addClass('hide');

    lvl++;
    let id = $(this).data('card_id');
    let reponse = findReponseInPath(id);
    if (testData(tmpTree, reponse)) {
        let children = tmpTree[0].children;
        children.forEach(function (child) {
            if (child.id === id) {
                $('.small-card-question').last();
                if (testData(child.children, child)) {
                    displaySmallQuestions(tmpTree[0], child, lvl);
                    path.push(clone(tmpTree[0]));
                    tmpTree = child.children;
                    displayBigQuestions(tmpTree, lvl);
                }
            }
        });
    }
});

$(document).on('click', '.small-card-question',  function() {
    let id  = $(this).data('card_id');
    let level = $(this).data('lvl');
    let smallCards = $('.small-card-question');

    $('.alert-no-more-element').removeClass('show');
    $('.alert-no-more-element').addClass('hide');

    smallCards.each(function(index, smallCard) {
        if (smallCard.dataset.lvl >= level) {
            $(smallCard).remove();
        }
    });

    lvl = level
    tmpTree = [findReponseInPath(id)];
    if (testData(tmpTree, tmpTree))  {
        displayBigQuestions(tmpTree, level);
    }
});

function findReponseInPath(id) {
    let cloneElement;
    path.forEach(function(element) {
        if (element.id === id) {
            cloneElement = clone(element);
            return false;
        }
    });

    return cloneElement;
}

function findReponse(tree, id) {
    if (tree[0].id !== id) {
        if (tree[0].hasOwnProperty(myProp)) {
            let children = tree[0].children;

            children.forEach(function (child) {
                if (child.hasOwnProperty(myProp)) {

                    var reponses = child.children;

                    reponses.forEach(function (reponse) {
                        findReponse(reponse, id);
                    });
                } else {
                    return 0;
                }
            });
        } else {
            return 0;
        }
    } else {
        return tree[0];
    }
    return 0;
}


function displaySmallQuestions(tmpData, tmpChild, lvl) {
    $('.questions-short').append('<div class="card border-success mb-3 small-card-question" data-lvl="' + lvl + '"  data-card_id="' + tmpData.id  + '" style="max-width: 18rem;">\n' +
        '                    <div class="card-header">\n' +
        '                        <div class="card-text">' + tmpData.short + '</div>\n' +
        '                    </div>\n' +
        '                    <div class="card-body text-primary">\n' +
        '                        <p class="card-text">' + tmpChild.short + '</p>\n' +
        '                    </div>\n' +
        '                </div>')
}

function displayBigQuestions(tmpData, lvl) {
    $('.question-long h3').remove();
    $('.question-long').html('<h3>' + tmpData[0].q_long + '</h3>');
    $('.questions').empty();

    let children = tmpData[0].children;
    let nChildren = children.length;
    console.log(nChildren);
    console.log(nChildren > 4);

    children.forEach(function(child, index) {
        if (child.gammeEnveloppe) {
            if (nChildren > 4) {
                $('.questions').append(' <a href="/configurateur/config/' + child.gammeEnveloppe + '" class="col-md-4 big-card-question" data-card_id="' + child.id + '" data-lvl="' + lvl + '" target="_blank">\n' +
                    '                                    <div class="card text-white bg-success mb-3">\n' +
                    '                                        <div class="card-header">\n' +
                    '                                            <h5 class="card-title">' + child.short + '</h5>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="card-body">\n' +
                    '                                            <p class="card-text"> ' + child.information + '</p>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="card-footer">\n' +
                    '                                            <div class="row justify-content-center"> <div class="col-8"><img src="../uploads/images/reponse/' +  child.img + '" class="card-img-top" ></div></div>\n' +
                    '                                            \n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </a>');
            }
            else {
                $('.questions').append(' <a href="/configurateur/config/' + child.gammeEnveloppe + '" class="col-md-' + 12 / nChildren + ' big-card-question" data-card_id="' + child.id + '" data-lvl="' + lvl + '" target="_blank">\n' +
                    '                                    <div class="card text-white bg-success mb-3">\n' +
                    '                                        <div class="card-header">\n' +
                    '                                            <h5 class="card-title">' + child.short + '</h5>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="card-body">\n' +
                    '                                            <p class="card-text"> ' + child.information + '</p>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="card-footer">\n' +
                    '                                            <div class="row justify-content-center"> <div class="col-8"><img src="../uploads/images/reponse/' +  child.img + '" class="card-img-top" ></div></div>\n' +
                    '                                            \n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </a>');
            }

        } else {
            if (nChildren > 4) {
                $('.questions').append(' <div class="col-md-4 big-card-question" data-card_id="' + child.id + '" data-lvl="' + lvl + '">\n' +
                    '                                    <div class="card text-white bg-success mb-3">\n' +
                    '                                        <div class="card-header">\n' +
                    '                                            <h5 class="card-title">' + child.short + '</h5>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="card-body">\n' +
                    '                                            <p class="card-text"> ' + child.information + '</p>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="card-footer">\n' +
                    '                                            <div class="row justify-content-center"> <div class="col-8"><img src="../uploads/images/reponse/' + child.img + '" class="card-img-top" ></div></div>\n' +
                    '                                            \n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>');

            } else {

                $('.questions').append(' <div class="col-md-' + 12 / nChildren + ' big-card-question" data-card_id="' + child.id + '" data-lvl="' + lvl + '">\n' +
                    '                                    <div class="card text-white bg-success mb-3">\n' +
                    '                                        <div class="card-header">\n' +
                    '                                            <h5 class="card-title">' + child.short + '</h5>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="card-body">\n' +
                    '                                            <p class="card-text"> ' + child.information + '</p>\n' +
                    '                                        </div>\n' +
                    '                                        <div class="card-footer">\n' +
                    '                                            <div class="row justify-content-center"> <div class="col-8"><img src="../uploads/images/reponse/' + child.img + '" class="card-img-top" ></div></div>\n' +
                    '                                            \n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>');
            }
        }

    });
}

function clone(obj) {
    if (null == obj || "object" != typeof obj) return obj;
    var copy = obj.constructor();
    for (var attr in obj) {
        if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
    }
    return copy;
}

function testData(data, reponse) {
    if (typeof data !== 'undefined') {
        return 1;
    } else {
        if (!reponse.gammeEnveloppe) {
            $('.alert-no-more-element').removeClass('hide');
            $('.alert-no-more-element').addClass('show');
        }
        return 0;
    }
}

