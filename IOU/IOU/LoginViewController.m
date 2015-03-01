//
//  LoginViewController.m
//  IOU
//
//  Created by Bandi Enkh-Amgalan on 3/1/15.
//  Copyright (c) 2015 a. All rights reserved.
//

#import "LoginViewController.h"
#import <FacebookSDK/FacebookSDK.h>

@interface LoginViewController ()
@end

@implementation LoginViewController
@synthesize loginView;
@synthesize delegate;

- (void)viewDidLoad {
    [super viewDidLoad];
    self.loginView = [[FBLoginView alloc] init];
    self.loginView.frame = CGRectOffset(self.loginView.frame, (self.view.center.x - (loginView.frame.size.width / 2)), self.view.center.y - (loginView.frame.size.height / 2));
    [self.view addSubview:self.loginView];
    if([FBSession activeSession].isOpen)
        [self.delegate didLogin];
    // Do any additional setup after loading the view.
}

- (void) loginViewShowingLoggedInUser:(FBLoginView *)loginView
{
    [self.delegate didLogin];
}

- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

/*
#pragma mark - Navigation

// In a storyboard-based application, you will often want to do a little preparation before navigation
- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    // Get the new view controller using [segue destinationViewController].
    // Pass the selected object to the new view controller.
}
*/

@end
