#!/bin/bash
zip -r /tmp/a.zip app/Resources/views/* src/AppBundle/* web/css/* web/js/*
scp -P 2753 /tmp/a.zip antony@voosearch.com:/tmp/
