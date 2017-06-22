latest_commit=$(git log -1 --format=%cd);
sed -i.tmp "s/\${latest_commit}/$latest_commit/" ./app/Resources/views/base.html.twig
mv ./app/Resources/views/base.html.twig.tmp ./app/Resources/views/base.html.twig
rm -rf ./app/Resources/views/base.html.twig.tmp