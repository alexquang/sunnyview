#!/bin/bash
zip -r -ll zipfile.zip $1 && unzip -o zipfile.zip && rm zipfile.zip