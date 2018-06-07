var $ = function(_id)
{
  return document.getElementById(_id);
};

var selChild = function(_id1, _id2)
{
  var tid1 = _id1;
  var tid2 = _id2;
  var tObj1 = $(tid1);
  var tObj2 = $(tid2);
  if (tObj1 && tObj2)
  {
    if (tObj2.className == 'hidden')
    {
      tObj2.className = 'show';
      if (tObj1.className == 'folder00') tObj1.className = 'folder01';
      if (tObj1.className == 'folder10') tObj1.className = 'folder11';
      if (tObj1.className == 'folder20') tObj1.className = 'folder21';
    }
    else
    {
      tObj2.className = 'hidden';
      if (tObj1.className == 'folder01') tObj1.className = 'folder00';
      if (tObj1.className == 'folder11') tObj1.className = 'folder10';
      if (tObj1.className == 'folder21') tObj1.className = 'folder20';
    };
  };
};

var switchMenu = function()
{
  var tMenuObj = $('tdMenu');
  if (tMenuObj)
  {
    if (tMenuObj.style.display == 'none') tMenuObj.style.display = '';
    else tMenuObj.style.display = 'none';
  };
}; 